<?php

namespace Modules\Budgets\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AccountsCollection extends ResourceCollection
{
    public $collects = AccountResource::class;

    public static $wrap = 'accounts';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}