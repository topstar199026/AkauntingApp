<?php

namespace Modules\Projects\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Projects\Jobs\Comments\CreateComment;
use Modules\Projects\Jobs\Comments\DeleteComment;
use Modules\Projects\Jobs\Comments\UpdateComment;
use Modules\Projects\Models\Comment;
use Modules\Projects\Models\Discussion;
use Modules\Projects\Models\Project;

class Comments extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Project $project, Discussion $discussion, Request $request)
    {
        $request->merge([
            'company_id' => company_id(),
            'project_id' => $project->id,
            'discussion_id' => $discussion->id,
        ]);

        $response = $this->ajaxDispatch(new CreateComment($request->except('_token', '_method')));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#discussions';

        if ($response['success']) {
            $message = trans('projects::messages.success.added', [
                'type' => trans_choice('projects::general.comments', 1),
            ]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Project $project, Discussion $discussion, Comment $comment, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdateComment($comment, $request));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#discussions';

        if ($response['success']) {
            $message = trans('projects::messages.success.updated', [
                'type' => trans_choice('projects::general.comments', 1),
            ]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Project $project, Discussion $discussion, Comment $comment, Request $request)
    {
        $request->merge([
            'company_id' => company_id(),
        ]);

        $response = $this->ajaxDispatch(new DeleteComment($request));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#discussions';

        if ($response['success']) {
            $message = trans('projects::messages.success.deleted', [
                'type' => trans_choice('projects::general.comments', 1),
            ]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }
}
