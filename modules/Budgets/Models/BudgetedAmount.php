<?php

namespace Modules\Budgets\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\DoubleEntry\Models\Account;

/**
 * This model represents the budgeted amounts.
 * @property int $id The primary key.
 * @property int $company_id The company for which this amount was created.
 * @property int $budget_id The budget for which this amount is created.
 * @property int $account_id The account to which this amount applies.
 * @property float $amount The budgeted value, will later be compared with actual.
 * @property \Illuminate\Support\Carbon $start_date The starting date to which this applies.
 * @property \Illuminate\Support\Carbon $end_date The ending date to which this applies.
 * @property \Illuminate\Support\Carbon $created_at The datetime when the record was created.
 * @property \Illuminate\Support\Carbon $updated_at The datetime when the record was updated.
 */
class BudgetedAmount extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'budget_id',
        'account_id',
        'amount',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'amount' => 'float',
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
    ];

    protected $forceDeleting = true;

    /**
     * Disable soft deletes for this model
     */
    public static function bootSoftDeletes()
    {
    }

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}