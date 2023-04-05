<?php

namespace Modules\Helpdesk\Models;

use App\Abstracts\Model;

class Priority extends Model
{
    protected $table = 'helpdesk_priorities';

    protected $fillable = ['id', 'company_id', 'name', 'order', 'created_from', 'created_by'];

    /**
     * Define accessor for translations
     * 
     * @return string
     */
    public function getNameAttribute($value)
    {
        return trans('helpdesk::general.priority.' . $value);
    }

    public static function getDefaultPriorityID()
    {
        $priorities = self::get();

        // Default priority: Medium
        return $priorities->where('default', true)->pluck('id')->first();
    }
}
