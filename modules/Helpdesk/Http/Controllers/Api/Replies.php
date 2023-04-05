<?php

namespace Modules\Helpdesk\Http\Controllers\Api;

use App\Abstracts\Http\ApiController;
use Modules\Helpdesk\Http\Requests\Reply as Request;
use Modules\Helpdesk\Http\Resources\Reply as Resource;
use Modules\Helpdesk\Jobs\CreateReply;
use Modules\Helpdesk\Jobs\DeleteReply;
use Modules\Helpdesk\Jobs\UpdateReply;
use Modules\Helpdesk\Models\Reply;

class Replies extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $replies = Reply::collect();

        return Resource::collection($replies);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $reply = Reply::find($id);

        return new Resource($reply);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $reply = $this->dispatch(new CreateReply($request));

        return $this->created(route('api.helpdesk.replies.show', $reply->id), new Resource($reply));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $reply
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Reply $reply, Request $request)
    {
        $reply = $this->dispatch(new UpdateReply($reply, $request));

        return new Resource($reply->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $reply = Reply::all()->find($id);

        if ($reply !== null) {
            try {
                $this->dispatch(new DeleteReply($reply));
                return $this->noContent();
            } catch (\Exception $e) {
                $this->errorUnauthorized($e->getMessage());
            }
        } else {
            return $this->errorNotFound();
        }
    }
}
