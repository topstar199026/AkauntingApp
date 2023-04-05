<?php

namespace Modules\Helpdesk\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Response;
use Modules\Helpdesk\Http\Requests\Reply as Request;
use Modules\Helpdesk\Jobs\CreateReply;
use Modules\Helpdesk\Jobs\UpdateReply;
use Modules\Helpdesk\Jobs\DeleteReply;
use Modules\Helpdesk\Models\Reply;

class Replies extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * 
     * @return Response
     */
    public function store(Request $request)
    {
        $response = $this->ajaxDispatch(new CreateReply($request));

        $response['redirect'] = route('helpdesk.tickets.show', $request->get('ticket_id'));

        if ($response['success']) {
            $message = trans('messages.success.added', ['type' => trans_choice('helpdesk::general.replies', 1)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Show the specified resource.
     *
     * @param $reply
     * 
     * @return Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $reply
     * 
     * @return Response
     */
    public function edit(Reply $reply)
    {
        return $reply;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Reply $reply
     * @param  Request $request
     *
     * @return Response
     */
    public function update(int $reply_id, Request $request)
    {
        $reply = Reply::where('id', $reply_id)->first();

        $response = $this->ajaxDispatch(new UpdateReply($reply, $request));

        $response['redirect'] = route('helpdesk.tickets.show', $request->get('ticket_id'));

        if ($response['success']) {
            $message = trans('messages.success.updated', ['type' => trans_choice('helpdesk::general.replies', 1)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $reply
     *
     * @return Response
     */
    public function destroy(Reply $reply)
    {
        $response = $this->ajaxDispatch(new DeleteReply($reply));

        $response['redirect'] = route('helpdesk.tickets.show', $reply->ticket_id);

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => trans_choice('helpdesk::general.replies', 1)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }
}
