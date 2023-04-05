<?php

namespace Modules\Projects\Http\Controllers\Portal;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Projects\Exports\TransactionsExport;
use Modules\Projects\Models\Project;

class Projects extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with('users.user.media')->where('customer_id', user()->contact->id)->collect();

        return view('projects::portal.index', compact('projects'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
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
        ];

        return view('projects::portal.show', compact('project', 'tabs'));
    }

    public function exportTransactions(Project $project)
    {
        return Excel::download(new TransactionsExport($project), 'transactions.xlsx');
    }
}
