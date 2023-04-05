<?php

namespace Modules\Helpdesk\Http\Controllers\Portal;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Response;
use Modules\Helpdesk\Models\Status;

class Statuses extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $statuses = Status::collect();

        return $this->response('helpdesk::portal.statuses.index', compact('statuses'));
    }
}
