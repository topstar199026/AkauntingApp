<?php

namespace Modules\Helpdesk\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Media;
use App\Models\Common\Media as MediaModel;

class Ticket extends Model
{
    use HasFactory, Media;

    protected $table = 'helpdesk_tickets';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['document_ids', 'statuses'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'name', 'subject', 'message', 'category_id', 'status_id', 'priority_id', 'assignee_id', 'created_from', 'created_by'];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = ['name', 'subject', 'category.name', 'status.name', 'priority_id', 'owner.name', 'assignee.name', 'created_at'];

    public function category()
    {
        return $this->belongsTo('App\Models\Setting\Category')->withDefault(['name' => trans('general.na')]);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function assignee()
    {
        return $this->belongsTo('App\Models\Auth\User')->withDefault(['name' => trans('general.na')]);
    }

    public function documents()
    {
        return $this->hasMany('Modules\Helpdesk\Models\TicketDocument');
    }

    /**
     * Accessors to provide default value on null
     */
    public function getStatusIdAttribute($value)
    {
        return $value ?? Status::getFirstStatusID();
    }

    public function getPriorityIdAttribute($value)
    {
        return $value ?? Priority::getDefaultPriorityID();
    }

    /**
     * Name accessor. Returns ticket name (dynamically generated)
     * 
     * @return String
     */
    public function getNameAttribute($value)
    {
        // In first versions the id was used as 'name'.
        // To keep compatibility we check for empty 'name' property.
        return '#' . (int) $value;
    }

    /**
     * Name mutator. Returns ticket name (dynamically generated)
     * 
     * @return string
     */
    public function setNameAttribute($value = null)
    {
        $value = (int) setting('helpdesk.tickets.next'); // 1 if module was just installed
        
        // Add 0s to allow Natural Sorting
        $this->attributes['name'] = str_pad($value, 10, '0', STR_PAD_LEFT);

        setting([
            'helpdesk.tickets.next' => ($value + 1) // Next ticket
        ])->save();
    }

    /**
     * Functions required to preload/delete attachments in tickets
     */
    public function getAttachmentAttribute($value = null)
    {
        if (!empty($value) && !$this->hasMedia('attachment')) {
            return $value;
        } elseif (!$this->hasMedia('attachment')) {
            return false;
        }

        return $this->getMedia('attachment')->all();
    }

    public function delete_attachment()
    {
        $attachments = $this->attachment;

        if (!empty($attachments)) {
            foreach ($attachments as $file) {
                MediaModel::where('id', $file->id)->delete();
            }
        }
    }

    /**
     * Get the document ids.
     *
     * @return string
     */
    public function getDocumentIdsAttribute()
    {
        return $this->documents()->pluck('document_id');
    }

    /**
     * Get the document ids.
     *
     * @return string
     */
    public function getStatusesAttribute()
    {
        $statuses = Status::all()->pluck('name', 'id');
        return $statuses;
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
            'title' => trans('general.edit'),
            'icon' => 'edit',
            'url' => route('helpdesk.tickets.edit', $this->id),
            'permission' => 'update-helpdesk-tickets',
        ];

        $actions[] = [
            'type' => 'delete',
            'title' => trans_choice('helpdesk::general.tickets', 1),
            'icon' => 'delete',
            'route' => 'helpdesk.tickets.destroy',
            'permission' => 'delete-helpdesk-tickets',
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
        return \Modules\Helpdesk\Database\Factories\Ticket::new();
    }
}
