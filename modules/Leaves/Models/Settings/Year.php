<?php

namespace Modules\Leaves\Models\Settings;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Year extends Model
{
    use HasFactory;

    protected $table = 'leaves_years';

    protected $fillable = ['company_id', 'name', 'start_date', 'end_date'];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date'   => 'date:Y-m-d',
    ];

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
                'url' => route('leaves.settings.years.edit',  $this->id),
                'permission' => 'update-leaves-settings',
            ],
            [
                'type' => 'delete',
                'title' => trans_choice('leaves::general.years', 1),
                'icon' => 'delete',
                'route' => 'leaves.settings.years.destroy',
                'permission' => 'update-leaves-settings',
                'model' => $this,
            ],
        ];

        return $actions;
    }

    protected static function newFactory(): Factory
    {
        return \Modules\Leaves\Database\Factories\Year::new();
    }
}
