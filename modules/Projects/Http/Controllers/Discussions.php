<?php

namespace Modules\Projects\Http\Controllers;

use App\Abstracts\Http\Controller;
use App\Models\Auth\User;
use App\Traits\DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Projects\Jobs\DiscussionLikes\CreateDiscussionLike;
use Modules\Projects\Jobs\Discussions\CreateDiscussion;
use Modules\Projects\Jobs\Discussions\DeleteDiscussion;
use Modules\Projects\Jobs\Discussions\UpdateDiscussion;
use Modules\Projects\Models\Comment;
use Modules\Projects\Models\Discussion;
use Modules\Projects\Models\DiscussionLike;
use Modules\Projects\Models\Project;
use Modules\Projects\Traits\Modals;

class Discussions extends Controller
{
    use DateTime, Modals;

    public function index(Project $project)
    {
        $discussions = $project->discussions()->collect();

        return view('projects::part.discussions', compact('project', 'discussions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Project $project)
    {
        return $this->getModal('create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Project $project, Request $request)
    {
        $params = $request->only('subject', 'description') + [
            'project_id' => $project->id,
            'company_id' => company_id(),
        ];

        $response = $this->ajaxDispatch(new CreateDiscussion($params));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#discussions';

        if ($response['success']) {
            $message = trans('projects::messages.success.added', [
                'type' => trans_choice('projects::general.discussions', 1),
            ]);

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
     * @return Response
     */
    public function show(Project $project, Discussion $discussion)
    {
        $response_json = $this->getModal('show', compact('project', 'discussion'));

        $data = $response_json->getData();

        if ($data->success) {
            $data->data->title = $discussion->subject;
            $response_json->setData($data);
        }

        return $response_json;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Project $project, Discussion $discussion)
    {
        return $this->getModal('edit', compact('project', 'discussion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function update(Project $project, Discussion $discussion, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdateDiscussion($discussion, $request));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#discussions';

        if ($response['success']) {
            $message = trans('projects::messages.success.updated', [
                'type' => trans_choice('projects::general.discussions', 1),
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
     *
     * @return Response
     */
    public function destroy(Project $project, Discussion $discussion, Request $request)
    {
        $response = $this->ajaxDispatch(new DeleteDiscussion($discussion, $request));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#discussions';

        if ($response['success']) {
            $message = trans('projects::messages.success.deleted', [
                'type' => trans_choice('projects::general.discussions', 1),
            ]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function comments(Discussion $discussion, Request $request)
    {
        $comments = Comment::where('discussion_id', $discussion->id)->orderBy('created_at', 'asc')->get();

        foreach ($comments as $comment) {
            $user = User::where('id', $comment->created_by)->first();
            $comment->created_by = $user->name;

            if ($user->picture) {
                if (setting('default.use_gravatar', '0') == '1') {
                    $comment['user_image_path'] = $user->picture;
                } else {
                    $comment['user_image_path'] = Storage::url($user->picture->id);
                }
            } else {
                $comment['user_image_path'] = asset('public/img/user.svg');
            }
        }

        return response()->json([
            'success' => true,
            'error' => false,
            'data' => $comments,
        ]);
    }

    public function like(Project $project, Discussion $discussion)
    {
        $like = DiscussionLike::where(['discussion_id' => $discussion->id, 'created_by' => user()->id])->withTrashed()->first();

        if (is_null($like)) {
            $response = $this->ajaxDispatch(new CreateDiscussionLike([
                'company_id' => company_id(),
                'project_id' => $project->id,
                'discussion_id' => $discussion->id,
                'created_by' => user()->id,
            ]));

            $status = 'like';
        } else {
            try {
                DB::transaction(function () use ($like) {
                    if ($like->trashed()) {
                        $like->restore();
                    } else {
                        $like->delete();
                    }
                });
            } catch (\Throwable $th) {
                $response['message'] = $th->getMessage();
            }

            $status = $like->trashed() ? 'unlike' : 'like';
        }

        $success = empty($response['message']) ? true : false;

        return response()->json([
            'success' => $success,
            'error' => ! $success,
            'message' => $response['message'] ?? null,
            'status' => $status,
        ]);
    }
}
