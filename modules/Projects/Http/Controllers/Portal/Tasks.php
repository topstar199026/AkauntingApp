<?php

namespace Modules\Projects\Http\Controllers\Portal;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Projects\Jobs\Tasks\CreateTask;
use Modules\Projects\Models\Project;
use Modules\Projects\Models\Task;
use Modules\Projects\Traits\Modals;

class Tasks extends Controller
{
    use Modals;
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
        $request->merge(['company_id' => company_id()]);

        $response = $this->ajaxDispatch(new CreateTask($request));

        $response['redirect'] = route('portal.projects.projects.show', $project->id);

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
    public function show(Project $project, Task $task)
    {
        return $this->getModal('show', compact('project', 'task'));
    }
}
