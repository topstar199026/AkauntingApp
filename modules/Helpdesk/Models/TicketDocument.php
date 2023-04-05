<?php

namespace Modules\Helpdesk\Models;

use App\Abstracts\Model;

class TicketDocument extends Model
{
    protected $table = 'helpdesk_ticket_documents';

    protected $fillable = ['company_id', 'ticket_id', 'document_id'];

    public function ticket()
    {
        return $this->belongsTo('Modules\Helpdesk\Models\Ticket');
    }

    public function document()
    {
        return $this->belongsTo('App\Models\Document\Document');
    }
}
