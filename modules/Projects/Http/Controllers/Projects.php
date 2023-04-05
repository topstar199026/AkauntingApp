<?php

namespace Modules\Projects\Http\Controllers;

use App\Abstracts\Http\Controller;
use App\Traits\Uploads;
use App\Models\Common\Contact;
use App\Models\Setting\Currency;
use Modules\Projects\Exports\TimesheetsExport;
use Modules\Projects\Exports\TransactionsExport;
use Modules\Projects\Http\Requests\Project as Request;
use Modules\Projects\Jobs\Projects\CreateInvoice;
use Modules\Projects\Jobs\Projects\CreateProject;
use Modules\Projects\Jobs\Projects\DeleteProject;
use Modules\Projects\Jobs\Projects\UpdateProject;
use Modules\Projects\Models\Project;
use Modules\Projects\Models\ProjectUser;


class Projects extends Controller
{
    use Uploads;

    public function index()
    {
        $projects = Project::with('users.user.media')->collect();

        return view('projects::projects.index', compact('projects'));
    }

    public function create()
    {
        $contacts = Contact::type(['customer', 'vendor'])->pluck('name', 'id');

        // $users = company()->users()->pluck('name', 'id');
        $users = json_encode(company()->users()->pluck('name', 'id'));


        $billing_types = [
            'fixed-rate' => trans('projects::general.fixed_rate'),
            'projects-hours' => trans('projects::general.projects_hours'),
            'task-hours' => trans('projects::general.task_hours'),
        ];

        $currency = Currency::code(setting('default.currency'))->first();

        return view('projects::projects.create', compact('contacts', 'users', 'billing_types', 'currency'));
    }

    public function store(Request $request)
    {
        $response = $this->ajaxDispatch(new CreateProject($request));

        if ($response['success']) {
            $response['redirect'] = route('projects.projects.index');

            $message = trans('messages.success.added', ['type' => trans_choice('projects::general.projects', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('projects.projects.create');

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function show(Project $project)
    {
        $tabs = [
            'overview',
            'tasks',
            'timesheets',
            'milestones',
            'activities',
            'transactions',
            'discussions',
            'attachments',
            'users',
        ];

        return view('projects::projects.show', compact('project', 'tabs'));
    }

    public function edit(Project $project)
    {
        $contacts = Contact::type(['customer', 'vendor'])->pluck('name', 'id');

        $statuses = [
            'inprogress' => trans('projects::general.inprogress'),
            'completed' => trans('projects::general.completed'),
            'canceled' => trans('projects::general.canceled'),
        ];

        // $users = company()->users()->pluck('name', 'id');
        $users = json_encode(company()->users()->pluck('name', 'id'));

        $billing_types = [
            'fixed-rate' => trans('projects::general.fixed_rate'),
            'projects-hours' => trans('projects::general.projects_hours'),
            'task-hours' => trans('projects::general.task_hours'),
        ];

        $currency = Currency::code(setting('default.currency'))->first();

        $members = json_encode(ProjectUser::where('project_id', '=', $project->id)->pluck('user_id'));

        return view('projects::projects.edit', compact('project', 'contacts', 'statuses', 'users', 'members', 'billing_types', 'currency'));
    }

    public function update(Project $project, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdateProject($project, $request));

        if ($response['success']) {
            $response['redirect'] = route('projects.projects.index');

            $message = trans('messages.success.updated', ['type' => trans_choice('projects::general.projects', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('projects.projects.edit', $project->id);

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function destroy(Project $project)
    {
        $response = $this->ajaxDispatch(new DeleteProject($project));

        if ($response['success']) {
            $response['redirect'] = route('projects.projects.index');

            $message = trans('messages.success.deleted', ['type' => trans_choice('projects::general.projects', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('projects.projects.edit', $project->id);

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function invoice(Project $project)
    {
        if ($project->billing_type === 'fixed-rate') {
            $project_invoicing_type['single_line'] = trans('projects::general.single_line');
        } else {
            $project_invoicing_type = [
                'task_per_item' => trans('projects::general.task_per_item'),
                'all_timesheets_individually' => trans('projects::general.all_timesheets_individually'),
            ];
        }

        return response()->json([
            'success' => true,
            'error' => false,
            'data'    => [
                'title'   => trans('general.title.new', ['type' => trans_choice('projects::general.invoices', 1)]),
            ],
            'html' => view('projects::modals.invoice', compact('project', 'project_invoicing_type'))->render(),
        ]);
    }

    public function storeInvoice(Project $project)
    {
        request()->validate([
            'tasks' => ['required'],
            'project_invoicing_type' => ['required', 'string'],
        ]);

        $response = $this->ajaxDispatch(new CreateInvoice($project));

        if ($response['success']) {
            $response['message'] = trans('messages.success.added', ['type' => trans_choice('general.invoices', 1)]);

            $response['redirect'] = route('invoices.show', $response['data']->id);

            flash($response['message'])->success();
        } else {
            $response['redirect'] = route('projects.projects.show', $project->id);

            flash($response['message'])->error()->important();
        }

        return response()->json($response);
    }

    public function attachments(Project $project, \Illuminate\Http\Request $request)
    {
        foreach ($request->file('attachment') ?? [] as $attachment) {
            $project->attachMedia($this->getMedia($attachment, "projects/{$project->id}"), 'attachment');
        }

        flash(trans('messages.success.added', ['type' => trans_choice('general.attachments', 1)]))->success();

        return response()->json([
            'success' => true,
            'error' => false,
            'redirect' => route('projects.projects.show', $project->id . '#attachments')
        ]);
    }

    public function printProject(Project $project, Request $request)
    {
        return $this->index();

        $date_format = $this->getCompanyDateFormat();
        $transactions = $this->prepareDataForTransactionsTab($project, 999999);
        $profitMarginOfProject = $this->calculateProfitMargin($project);

        return view('projects::projects.print', compact('transactions', 'project', 'profitMarginOfProject', 'date_format'));
    }

    public function exportTransactions(Project $project)
    {
        return $this->exportExcel(new TransactionsExport($project->id), trans_choice('projects::general.transaction', 2));
    }

    public function exportTimesheets(Project $project)
    {
        return $this->exportExcel(new TimesheetsExport($project->id), trans_choice('projects::general.timesheet', 2));
    }
}
