<?php

namespace Modules\Budgets\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DEClassCollection extends ResourceCollection
{
    public $collects = DEClassResource::class;

    public static $wrap = 'de_class';

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