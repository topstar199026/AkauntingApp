<?php

namespace Modules\Projects\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Interfaces\Listener\ShouldUpdateAllCompanies;
use App\Models\Banking\Transaction;
use App\Models\Document\Document;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Projects\Models\Financial;
use Modules\Projects\Models\ProjectBill;
use Modules\Projects\Models\ProjectInvoice;
use Modules\Projects\Models\ProjectPayment;
use Modules\Projects\Models\ProjectRevenue;

class Version400 extends Listener
{
    const ALIAS = 'projects';

    const VERSION = '4.0.0';

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(UpdateFinished $event)
    {
        if ($this->skipThisUpdate($event)) {
            return;
        }

        $this->updateDatabase();

        $this->updateProjects();

        $this->updateFinancials();

        $this->deleteOldFilesFolders();
    }

    protected function updateDatabase()
    {
        Artisan::call('module:migrate', ['alias' => self::ALIAS, '--force' => true]);
    }

    protected function updateProjects()
    {
        DB::transaction(function () {
            DB::table('projects')
                ->where('status', '0')
                ->update(['status' => 'inprogress']);

            DB::table('projects')
                ->where('status', '1')
                ->update(['status' => 'completed']);

            DB::table('projects')
                ->where('status', '2')
                ->update(['status' => 'canceled']);

            DB::table('projects')
                ->where('billing_type', '1')
                ->update(['billing_type' => 'fixed-rate']);

            DB::table('projects')
                ->where('billing_type', '2')
                ->update(['billing_type' => 'projects-hours']);

            DB::table('projects')
                ->where('billing_type', '3')
                ->update(['billing_type' => 'task-hours']);

            DB::table('project_tasks')
                ->where('status', '1')
                ->update(['status' => 'not-started']);

            DB::table('project_tasks')
                ->where('status', '2')
                ->update(['status' => 'active']);

            DB::table('project_tasks')
                ->where('status', '3')
                ->update(['status' => 'completed']);

            DB::table('project_tasks')
                ->where('priority', '1')
                ->update(['priority' => 'low']);

            DB::table('project_tasks')
                ->where('priority', '2')
                ->update(['priority' => 'medium']);

            DB::table('project_tasks')
                ->where('priority', '3')
                ->update(['priority' => 'high']);

            DB::table('project_tasks')
                ->where('priority', '4')
                ->update(['priority' => 'urgent']);
        });
    }

    protected function updateFinancials()
    {
        ProjectInvoice::all()
            ->each(function ($project_invoice) {
                Financial::create([
                    'company_id' => company_id(),
                    'project_id' => $project_invoice->project_id,
                    'financialable_id' => $project_invoice->invoice_id,
                    'financialable_type' => Document::class,
                ]);
            });

        ProjectBill::all()
            ->each(function ($project_bill) {
                Financial::create([
                    'company_id' => company_id(),
                    'project_id' => $project_bill->project_id,
                    'financialable_id' => $project_bill->bill_id,
                    'financialable_type' => Document::class,
                ]);
            });

        ProjectRevenue::all()
            ->each(function ($project_revenue) {
                Financial::create([
                    'company_id' => company_id(),
                    'project_id' => $project_revenue->project_id,
                    'financialable_id' => $project_revenue->revenue_id,
                    'financialable_type' => Transaction::class,
                ]);
            });

        ProjectPayment::all()
            ->each(function ($project_payment) {
                Financial::create([
                    'company_id' => company_id(),
                    'project_id' => $project_payment->project_id,
                    'financialable_id' => $project_payment->payment_id,
                    'financialable_type' => Transaction::class,
                ]);
            });
    }

    protected function deleteOldFilesFolders()
    {
        $files = [
            'Resources/assets/img/projects.png',
            'Http/Requests/ProjectRequest.php',
            'Http/Requests/TaskRequest.php',
            'Http/Requests/TimesheetRequest.php',
            'Http/Requests/MilestoneRequest.php',
            'Jobs/AssignTaskMembers.php',
            'Jobs/CreateTask.php',
            'Jobs/UpdateTask.php',
            'Jobs/DeleteTask.php',
            'Casts/TaskPriorityFormat.php',
            'Casts/TaskStatusFormat.php',
            'Http/Controllers/DiscussionLikes.php',
            'Resources/assets/js/activities.js',
            'Resources/assets/js/discussions.js',
            'Resources/assets/js/milestones.js',
            'Resources/assets/js/overview.js',
            'Resources/assets/js/tasks.js',
            'Resources/assets/js/timesheets.js',
            'Resources/assets/js/transactions.js',
            'Resources/assets/js/activities.min.js',
            'Resources/assets/js/discussions.min.js',
            'Resources/assets/js/milestones.min.js',
            'Resources/assets/js/overview.min.js',
            'Resources/assets/js/tasks.min.js',
            'Resources/assets/js/timesheets.min.js',
            'Resources/assets/js/transactions.min.js',
            'Resources/views/portal/activities.blade.php',
            'Resources/views/portal/discussions.blade.php',
            'Resources/views/portal/milestones.blade.php',
            'Resources/views/portal/overview.blade.php',
            'Resources/views/portal/tasks.blade.php',
            'Resources/views/portal/timesheets.blade.php',
            'Resources/views/portal/transactions.blade.php',
            'Resources/views/projects/activities.blade.php',
            'Resources/views/projects/discussions.blade.php',
            'Resources/views/projects/milestones.blade.php',
            'Resources/views/projects/overview.blade.php',
            'Resources/views/projects/tasks.blade.php',
            'Resources/views/projects/timesheets.blade.php',
            'Resources/views/projects/transactions.blade.php',
            'Resources/views/widgets/portal/progress_completed_tasks.blade.php',
            'Resources/views/widgets/portal/progress_days_left.blade.php',
        ];

        $directories = [
            'Resources/assets/js/widgets',
            'Resources/views/partials',
            'Resources/assets/js/portal',
        ];

        foreach ($files as $file) {
            File::delete(base_path('modules/Projects/' . $file));
        }

        foreach ($directories as $directory) {
            File::deleteDirectory(base_path('modules/Projects/' . $directory));
        }
    }
}
