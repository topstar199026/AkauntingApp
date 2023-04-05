<?php

namespace Modules\Budgets\Models;

use App\Abstracts\Model;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Budgets\Support\FinancialYear;
use Modules\Budgets\Traits\BudgetTrait;

/**
 * This model represents the budgets.
 * @property int $id The primary key.
 * @property int $company_id The company for which the budget was created.
 * @property string $name The name of the budget.
 * @property string $period The budgeting period (monthly/quarterly/yearly).
 * @property int $financial_year The financial year for which the budget was created.
 * @property \Illuminate\Support\Carbon $created_at The datetime when the record was created.
 * @property \Illuminate\Support\Carbon $updated_at The datetime when the record was updated.
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Budgets\Models\BudgetedAmount> $budgetedAmounts
 * @property-read \Carbon\CarbonPeriod $financial_period The financial period
 */
class Budget extends Model
{
    use HasFactory;
    use BudgetTrait;

    const PERIOD_MONTHLY = 'monthly';
    const PERIOD_QUARTERLY = 'quarterly';
    const PERIOD_YEARLY = 'yearly';

    protected $table = 'budgets';

    protected $fillable = [
        'company_id',
        'name',
        'financial_year',
        'period',
    ];

    protected $forceDeleting = true;

    /**
     * Disable soft deletes for this model
     */
    public static function bootSoftDeletes()
    {
    }

    public static function budgetPeriods(): array
    {
        return [
            self::PERIOD_MONTHLY => trans('general.' . self::PERIOD_MONTHLY),
            self::PERIOD_QUARTERLY => trans('general.' . self::PERIOD_QUARTERLY),
            self::PERIOD_YEARLY => trans('general.' . self::PERIOD_YEARLY),
        ];
    }

    public function budgetedAmounts(): HasMany
    {
        return $this->hasMany(BudgetedAmount::class);
    }

    public function getFinancialPeriodAttribute(): CarbonPeriod
    {
        return (new FinancialYear())->getFinancialYear($this->financial_year);
    }

    public function getFormattedFinancialYearAttribute(): string
    {
        return $this->financial_period->getStartDate()->format('M Y') . ' - ' . $this->financial_period->getEndDate()->format('M Y');
    }

    public function isMonthly(): bool
    {
        return $this->period === self::PERIOD_MONTHLY;
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute(): array
    {
        $actions = [];

        $actions[] = [
            'type' => 'report',
            'title' => trans('budgets::general.budget_vs_actual'),
            'icon' => 'visibility',
            'url' => route('budgets.show', $this),
            'permission' => 'read-budgets-budgets',
        ];

        $actions[] = [
            'title' => trans('general.edit'),
            'icon' => 'edit',
            'url' => route('budgets.edit', $this),
            'permission' => 'update-budgets-budgets',
        ];

        $actions[] = [
            'type' => 'delete',
            'title' => trans_choice('budgets::general.budget', 1),
            'icon' => 'delete',
            'route' => 'budgets.destroy',
            'permission' => 'delete-budgets-budgets',
            'model' => $this,
        ];

        return $actions;
    }
}
