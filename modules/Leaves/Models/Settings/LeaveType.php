<?php

namespace Modules\Leaves\Models\Settings;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveType extends Model
{
    use HasFactory;

    protected $table = 'leaves_leave_types';

    protected $fillable = ['company_id', 'name', 'description'];

    public function policies(): HasMany
    {
        return $this->hasMany(Policy::class);
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
                'url' => route('leaves.settings.leave-types.edit',  $this->id),
                'permission' => 'update-leaves-settings',
            ],
            [
                'type' => 'delete',
                'title' => trans_choice('leaves::general.leave_types', 1),
                'icon' => 'delete',
                'route' => 'leaves.settings.leave-types.destroy',
                'permission' => 'update-leaves-settings',
                'model' => $this,
            ],
        ];

        return $actions;
    }

    protected static function newFactory(): Factory
    {
        return \Modules\Leaves\Database\Factories\LeaveType::new();
    }
}
