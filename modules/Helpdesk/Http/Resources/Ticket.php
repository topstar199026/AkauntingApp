<?php

namespace Modules\Helpdesk\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ticket extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'subject' => $this->subject,
            'message' => $this->message,
            'category_id' => $this->company,
            'status_id' => $this->status_id,
            'priority_id' => $this->priority_id,
            'assignee_id' => $this->assignee_id,
            'created_by' => $this->created_by,
            'attachment' => $this->attachment,
            'document_ids' => $this->document_ids,
            'created_at' => $this->created_at ? $this->created_at->toIso8601String() : '',
            'updated_at' => $this->updated_at ? $this->updated_at->toIso8601String() : '',
        ];
    }
}