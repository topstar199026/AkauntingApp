<div class="dashboard flex flex-wrap lg:-mx-12">
    @if(! user()->isCustomer())
    {{-- @widget('Modules\Projects\Widgets\TotalInvoice', $project)
    @widget('Modules\Projects\Widgets\TotalRevenue', $project)
    @widget('Modules\Projects\Widgets\TotalBill', $project)
    @widget('Modules\Projects\Widgets\TotalPayment', $project)
    @widget('Modules\Projects\Widgets\TotalActivity', $project)
    @widget('Modules\Projects\Widgets\TotalTask', $project)
    @widget('Modules\Projects\Widgets\TotalDiscussion', $project)
    @widget('Modules\Projects\Widgets\TotalUser', $project) --}}
    @widget('Modules\Projects\Widgets\ProjectLineChart', $project)
    @widget('Modules\Projects\Widgets\LatestIncome', $project)
    @widget('Modules\Projects\Widgets\ActiveDiscussion', $project)
    @widget('Modules\Projects\Widgets\RecentlyAddedTask', $project)
    @else
    @widget('Modules\Projects\Widgets\Portal\ProjectBrief', $project)
    @widget('Modules\Projects\Widgets\Portal\ProgressCompletedTasks', $project)
    @widget('Modules\Projects\Widgets\Portal\ProgressDaysLeft', $project)
    @widget('Modules\Projects\Widgets\Portal\RecentlyAddedTasks', $project)
    @widget('Modules\Projects\Widgets\Portal\MostLoggedTasks', $project)
    @widget('Modules\Projects\Widgets\ActiveDiscussion', $project)
    @endif
    <style>
        .bg-gradient-default {
            background: linear-gradient(87deg, #3c3f72 0, #7376a0 100%) !important;
        }
    </style>
</div>
