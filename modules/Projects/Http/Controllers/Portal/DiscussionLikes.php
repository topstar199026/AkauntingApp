<?php

namespace Modules\Projects\Http\Controllers\Portal;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Projects\Models\Discussion;
use Modules\Projects\Models\DiscussionLike;
use Modules\Projects\Models\Project;

class DiscussionLikes extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $discussion_like = new DiscussionLike();
        $discussion_like->company_id = company_id();
        $discussion_like->project_id = $request->project_id;
        $discussion_like->discussion_id = $request->discussion_id;
        $discussion_like->created_by = Auth::id();

        $discussion_like->save();

        $discussion = Discussion::where('id', $request->discussion_id)->first();
        $discussion->total_like += 1;
        $discussion->save();

        $message = '';

        return response()->json([
            'success' => true,
            'error' => false,
            'data' => $discussion_like,
            'message' => $message,
            'totalLike' => $discussion->total_like,
        ]);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request)
    {
        $discussion_like = DiscussionLike::where(['discussion_id' => request()->segment(5), 'created_by' => Auth::id()])->first();
        $discussion_like->delete();

        $discussion = Discussion::where('id', request()->segment(5))->first();
        $discussion->total_like -= 1;
        $discussion->save();

        $message = '';

        return response()->json([
            'success' => true,
            'error' => false,
            'data' => $discussion_like,
            'message' => $message,
            'totalLike' => $discussion->total_like,
        ]);
    }
}
