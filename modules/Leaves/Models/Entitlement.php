<?php

namespace Modules\Leaves\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Employees\Models\Employee;
use Modules\Leaves\Models\Settings\Policy;

class Entitlement extends Model
{
    use HasFactory;

    protected $table = 'leaves_entitlements';

    protected $fillable = [
        'company_id',
        'policy_id',
        'employee_id',
    ];

    public function policy(): BelongsTo
    {
        return $this->belongsTo(Policy::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function allowances(): HasMany
    {
        return $this->hasMany(Allowance::class);
    }

    public function getRemainingDaysAttribute()
    {
        $this->loadMissing(['policy', 'allowances']);

        $usedDays = $this->allowances
            ->where('type', Allowance::TYPE_USED)
            ->sum('days');

        return $this->policy->days - $usedDays;
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        $click_function = \Illuminate\Support\Facades\Route::is('employees.employees.show') ? 'onModalAddNew' : 'registerLeave';

        $actions = [
            [
                'type' => 'button',
                'title' => trans('leaves::entitlements.register_leave'),
                'icon' => 'add',
                'permission' => 'create-leaves-entitlements',
                'attributes' => [
                    '@click' => $click_function . "('" . route('leaves.modals.entitlement.leaves.create', $this->id) . "')",
                ],
            ],
            [
                'type' => 'delete',
                'title' => trans_choice('leaves::general.entitlements', 1),
                'icon' => 'delete',
                'route' => 'leaves.entitlements.destroy',
                'permission' => 'delete-leaves-entitlements',
                'model' => $this,
            ],
        ];

        return $actions;
    }

    protected static function newFactory(): Factory
    {
        return \Modules\Leaves\Database\Factories\Entitlement::new();
    }
}
