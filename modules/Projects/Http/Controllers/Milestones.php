<?php

namespace Modules\Projects\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Response;
use Modules\Projects\Http\Requests\Milestone as Request;
use Modules\Projects\Jobs\Milestones\CreateMilestone;
use Modules\Projects\Jobs\Milestones\DeleteMilestone;
use Modules\Projects\Jobs\Milestones\UpdateMilestone;
use Modules\Projects\Models\Milestone as Model;
use Modules\Projects\Models\Project;
use Modules\Projects\Traits\Modals;

class Milestones extends Controller
{
    use Modals;

    public function index(Project $project)
    {
        $milestones = $project->milestones()->collect();

        return view('projects::part.milestones', compact('project', 'milestones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Project $project
     * @return Response
     */
    public function create(Project $project)
    {
        return $this->getModal('create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Project $project
     * @param Request $request
     * @return Response
     */
    public function store(Project $project, Request $request)
    {
        $response = $this->ajaxDispatch(new CreateMilestone($request));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#milestones';

        if ($response['success']) {
            $message = trans('messages.success.added', [
                'type' => trans_choice('projects::general.milestones', 1),
            ]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     * @param Model $milestone
     * @return Response
     */
    public function edit(Project $project, Model $milestone)
    {
        return $this->getModal('edit', compact('project', 'milestone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Project $project
     * @param Model $milestone
     * @param Request $request
     * @return Response
     */
    public function update(Project $project, Model $milestone, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdateMilestone($milestone, $request));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#milestones';

        if ($response['success']) {
            $message = trans('messages.success.updated', [
                'type' => trans_choice('projects::general.milestones', 1),
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
     * @param Project $project
     * @param Model $milestone
     * @return Response
     */
    public function destroy(Project $project, Model $milestone)
    {
        $response = $this->ajaxDispatch(new DeleteMilestone($milestone));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#milestones';

        if ($response['success']) {
            $message = trans('messages.success.deleted', [
                'type' => trans_choice('projects::general.milestones', 1),
            ]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }
}
