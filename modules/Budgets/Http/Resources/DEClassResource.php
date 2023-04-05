<?php

namespace Modules\Budgets\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DEClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => trans($this->name),
            'type' => $this->name === 'double-entry::classes.income' ? 'income' : 'expenses',
            'accounts' => new AccountsCollection($this->accounts),
        ];
    }
}