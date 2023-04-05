<?php

namespace Modules\Projects\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Response;
use Modules\Projects\Http\Requests\Task as Request;
use Modules\Projects\Jobs\Tasks\CreateTask;
use Modules\Projects\Jobs\Tasks\DeleteTask;
use Modules\Projects\Jobs\Tasks\UpdateTask;
use Modules\Projects\Models\Project;
use Modules\Projects\Models\Task as Model;
use Modules\Projects\Traits\Modals;

class Tasks extends Controller
{
    use Modals;

    public function index(Project $project)
    {
        $tasks = $project->tasks()->collect();

        return view('projects::part.tasks', compact('project', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Project $project)
    {
        $response_json = $this->getModal('create', compact('project'));

        $data = $response_json->getData();

        if ($data->success) {
            $data->data->large = true;
            $response_json->setData($data);
        }

        return $response_json;
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
        $response = $this->ajaxDispatch(new CreateTask($request));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#tasks';

        if ($response['success']) {
            $message = trans('messages.success.added', ['type' => trans_choice('projects::general.tasks', 1)]);

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
    public function show(Project $project, Model $task)
    {
        $response_json = $this->getModal('show', compact('project', 'task'));

        $data = $response_json->getData();

        if ($data->success) {
            $data->data->show = true;
            $data->data->large = true;
            $response_json->setData($data);
        }

        return $response_json;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     * @return Response
     */
    public function edit(Project $project, Model $task)
    {
        $response_json = $this->getModal('edit', compact('project', 'task'));

        $data = $response_json->getData();

        if ($data->success) {
            $data->data->large = true;
            $response_json->setData($data);
        }

        return $response_json;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Project $project
     * @param Model $task
     * @param Request $request
     * @return Response
     */
    public function update(Project $project, Model $task, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdateTask($task, $request));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#tasks';

        if ($response['success']) {
            $message = trans('messages.success.updated', ['type' => trans_choice('projects::general.tasks', 1)]);

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
    public function destroy(Project $project, Model $task)
    {
        $response = $this->ajaxDispatch(new DeleteTask($task));

        $response['redirect'] = route('projects.projects.show', $project->id) . '#tasks';

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $task->name]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }
}
