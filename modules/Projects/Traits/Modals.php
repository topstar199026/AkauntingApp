<?php

namespace Modules\Projects\Traits;

use App\Models\Setting\Currency;

trait Modals
{
    protected function getModal($method, $models)
    {
        try {
            $is_portal = str(get_class($this))->contains('Portal') ? '\Portal' : '' ;

            $controller_name = strtolower(str_replace("Modules\Projects\Http\Controllers{$is_portal}\\", '', get_class($this)));

            $view_name = "projects::modals.{$controller_name}.{$method}";

            $data = $this->{$controller_name}($method, (object) $models);

            $title_type = match ($method) {
                'create' => 'new',
                'edit' => 'edit',
                'show' => 'show',
            };

            $title = trans('general.title.' . $title_type, ['type' => trans_choice('projects::general.' . $controller_name, 1)]);

            $html = view($view_name, $data)->render();
        } catch (\Throwable $th) {
            logs()->error($th->getMessage(), ['trace' => $th->getTraceAsString()]);

            return response()->json([
                'success' => false,
                'error' => true,
                'message' => $th->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'error' => false,
            'data'    => [
                'title'   => $title,
            ],
            'html' => $html,
        ]);
    }

    protected function tasks($method_type, $models)
    {
        $currency = Currency::code(default_currency())
            ->first();

        $milestones = $models->project->milestones()->pluck('name', 'id');

        $is_task_hours = $models->project->billing_type === 'task-hours' ? 'true' : 'false';

        $priorities = [
            'low' => trans('projects::general.low'),
            'medium' => trans('projects::general.medium'),
            'high' => trans('projects::general.high'),
            'urgent' => trans('projects::general.urgent'),
        ];

        $users = $models->project->users()
            ->with('user')
            ->get()
            ->mapWithKeys(function ($project_user) {
                return [$project_user->user->id => $project_user->user->name];
            });

        $statuses = [
            'not-started' => trans('projects::general.not-started'),
            'active' => trans('projects::general.active'),
            'completed' => trans('projects::general.completed'),
        ];

        return compact('models','currency', 'milestones', 'is_task_hours', 'priorities', 'users', 'statuses');
    }

    protected function timesheets($method_type, $models)
    {
        $users = [];

        $tasks = $models->project->tasks()
            ->with(['users.user'])
            ->get()
            ->reject(function ($value) {
                return $value->status == 'completed';
            })
            ->each(function ($task) use (&$users) {
                foreach ($task->users as $task_user) {
                    // $users[$task->id][$task_user->user->id] = $task_user->user->name;
                    $users[$task_user->user->id] = $task_user->user->name;
                }
            })
            ->pluck('name', 'id');

        return compact('models', 'tasks', 'users');
    }

    protected function milestones($method_type, $models)
    {
        return compact('models');
    }

    protected function discussions($method_type, $models)
    {
        return compact('models');
    }
}
