<?php

namespace Modules\Projects\Http\Controllers;

use App\Abstracts\Http\Controller;
use App\Traits\DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Date;
use Modules\Projects\Jobs\ProjectTaskTimesheets\CreateProjectTaskTimesheet;
use Modules\Projects\Jobs\ProjectTaskTimesheets\DeleteProjectTaskTimesheet;
use Modules\Projects\Jobs\ProjectTaskTimesheets\UpdateProjectTaskTimesheet;
use Modules\Projects\Models\Project;
use Modules\Projects\Models\ProjectTaskTimesheet as Model;
use Modules\Projects\Models\Task;
use Modules\Projects\Traits\Modals;

class Timesheets extends Controller
{
    use DateTime, Modals;

    public function index(Project $project)
    {
        $timesheets = $project->timesheets()->collect();

        return view('projects::part.timesheets', compact('project', 'timesheets'));
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
     * @param Project $project
     * @param Request $request
     * @return Response
     */
    public function store(Project $project, Request $request)
    {
        $request['company_id'] = company_id();

        $response = $this->ajaxDispatch(new CreateProjectTaskTimesheet($request));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#timesheets';

        if ($response['success']) {
            $message = trans('messages.success.added', [
                'type' => trans_choice('projects::general.timesheets', 1),
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
     * @param ProjectTaskTimesheet $timesheet
     * @return Response
     */
    public function edit(Project $project, Model $timesheet)
    {
        return $this->getModal('edit', compact('project', 'timesheet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Project $project
     * @param Model $timesheet
     * @param Request $request
     * @return Response
     */
    public function update(Project $project, Model $timesheet, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdateProjectTaskTimesheet($timesheet, $request));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#timesheets';

        if ($response['success']) {
            $message = trans('messages.success.updated', ['type' => trans_choice('projects::general.timesheets', 1)]);

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
     * @param Model $timesheet
     * @return Response
     */
    public function destroy(Project $project, Model $timesheet)
    {
        $response = $this->ajaxDispatch(new DeleteProjectTaskTimesheet($timesheet));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#timesheets';

        if ($response['success']) {
            $message = trans('messages.success.deleted', [
                'type' => trans_choice('projects::general.timesheets', 1),
            ]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param Request $request
     * @return Response
     */
    public function start(Project $project, Task $task)
    {
        Model::create([
            'company_id' => company_id(),
            'project_id' => $project->id,
            'task_id' => $task->id,
            'user_id' => user()->id,
            'started_at' => Date::now(),
        ]);

        $message = trans('projects::messages.success.started', [
            'type' => trans('projects::general.timer'),
        ]);

        return response()->json([
            'success' => true,
            'error' => false,
            'redirect' => route('projects.projects.show', $project->id) . '#tasks',
            'message' => $message,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function stop(Project $project, Model $timesheet, Request $request)
    {
        $timesheet->update([
            'ended_at' => Date::now(),
        ]);

        $message = trans('projects::messages.success.stopped', [
            'type' => trans('projects::general.timer'),
        ]);

        return response()->json([
            'success' => true,
            'error' => false,
            'redirect' => route('projects.projects.show', $project->id) . '#tasks',
            'message' => $message,
        ]);
    }
}
