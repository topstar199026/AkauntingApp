<?php

namespace Modules\Helpdesk\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'helpdesk_replies';

    protected $fillable = ['company_id', 'ticket_id', 'message', 'category_id', 'internal', 'created_from', 'created_by'];

    public function ticket()
    {
        return $this->belongsTo('Modules\Helpdesk\Models\Ticket')->withDefault(['title' => trans('general.na')]);
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        $actions = [];

        $actions[] = [
            'type' => 'button',
            'title' => trans('general.edit'),
            'icon' => 'edit',
            'permission' => 'update-helpdesk-replies',
            'attributes' => [
                'id' => 'index-more-actions-edit-' . $this->id,
                '@click' => 'onReplyEditModalOpen(' . $this->id . ')',
            ],
        ];

        $actions[] = [
            'type' => 'delete',
            'title' => trans_choice('helpdesk::general.replies', 1),
            'icon' => 'delete',
            'route' => 'helpdesk.replies.destroy',
            'permission' => 'delete-helpdesk-replies',
            'model' => $this,
        ];

        return $actions;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Helpdesk\Database\Factories\Reply::new();
    }
}
