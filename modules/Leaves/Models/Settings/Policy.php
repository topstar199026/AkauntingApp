<?php

namespace Modules\Leaves\Models\Settings;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Leaves\Models\Entitlement;

class Policy extends Model
{
    use HasFactory;

    protected $table = 'leaves_policies';

    protected $fillable = [
        'company_id',
        'name',
        'leave_type_id',
        'year_id',
        'contract_type',
        'department_id',
        'gender',
        'days',
        'applicable_after',
        'carryover_days',
        'is_paid',
    ];

    public function leave_type(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function entitlements(): HasMany
    {
        return $this->hasMany(Entitlement::class);
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        $actions = [
            [
                'title' => trans('general.edit'),
                'icon' => 'edit',
                'url' => route('leaves.settings.policies.edit',  $this->id),
                'permission' => 'update-leaves-settings',
            ],
            [
                'type' => 'delete',
                'title' => trans_choice('leaves::general.policies', 1),
                'icon' => 'delete',
                'route' => 'leaves.settings.policies.destroy',
                'permission' => 'update-leaves-settings',
                'model' => $this,
            ],
        ];

        return $actions;
    }

    protected static function newFactory(): Factory
    {
        return \Modules\Leaves\Database\Factories\Policy::new();
    }
}
