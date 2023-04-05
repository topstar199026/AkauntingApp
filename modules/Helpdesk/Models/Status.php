<?php

namespace Modules\Helpdesk\Models;

use App\Abstracts\Model;
use Illuminate\Support\Collection;

class Status extends Model
{
    protected $table = 'helpdesk_statuses';

    protected $fillable = ['id', 'company_id', 'name', 'position', 'flow', 'created_from', 'created_by'];

    /**
     * Define accessor for translations
     * 
     * @return string
     */
    public function getNameAttribute($value)
    {
        return trans('helpdesk::general.status.' . $value);
    }

    /**
     * Get available statuses based on current status
     * 
     * @param status_id
     * 
     * @return Collection
     */
    public static function getAvailableStatuses(int $status_id): Collection
    {
        $statuses = self::get();

        if ($status_id == 0) {
            // The first status of the flow will be provided
            $output = $statuses->where('position', 'first');
        } else {
            // All statuses based on $status_id will be provided
            $flow = explode(',', $statuses->where('id', $status_id)->pluck('flow')->first());

            $output = collect();
            foreach ($statuses as $status) {
                if (in_array($status->flow_id, $flow)) {
                    $output->add($status);
                }
            }
        }

        return $output;
    }

    public static function getFirstStatusID()
    {
        $statuses = self::get();

        // Default first status: Open
        return $statuses->where('position', 'first')->pluck('id')->first();
    }

    public static function getLastStatusID()
    {
        $statuses = self::get();

        // Default last status: Closed
        return $statuses->where('position', 'last')->pluck('id')->first();
    }
}
