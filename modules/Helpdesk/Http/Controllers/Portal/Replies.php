<?php

namespace Modules\Helpdesk\Http\Controllers\Portal;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Response;
use Modules\Helpdesk\Http\Requests\Reply as Request;
use Modules\Helpdesk\Jobs\CreateReply;

class Replies extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $response = $this->ajaxDispatch(new CreateReply($request));

        $response['redirect'] = route('portal.helpdesk.tickets.show', $request->get('ticket_id'));

        if ($response['success']) {
            $message = trans('messages.success.added', ['type' => trans_choice('helpdesk::general.replies', 1)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }
}
