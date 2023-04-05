<?php

namespace Modules\Budgets\Http\Controllers;

use App\Abstracts\Http\Controller;
use App\Models\Common\Company;
use App\Models\Common\Report;
use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\Budgets\Http\Requests\BudgetRequest;
use Modules\Budgets\Http\Resources\DEClassCollection;
use Modules\Budgets\Jobs\Budget\CreateBudget;
use Modules\Budgets\Jobs\Budget\DeleteBudget;
use Modules\Budgets\Jobs\Budget\UpdateBudget;
use Modules\Budgets\Models\Budget;
use Modules\Budgets\Reports\BudgetVsActual;
use Modules\Budgets\Support\FinancialYear;
use Modules\DoubleEntry\Models\DEClass;

class Budgets extends Controller
{
    public function index()
    {
        return $this->response('budgets::index', [
            'budgets' => Budget::latest()->paginate(),
            'is_double_entry_installed' => $this->isDoubleEntryModuleInstalled(),
        ]);
    }

    public function show(Budget $budget)
    {
        $report = new Report();
        $report->company_id = Company::getCurrent()->id;
        $report->class = BudgetVsActual::class;
        $report->name = sprintf('%s: %s', trans('budgets::general.budget_vs_actual'), $budget->name);
        $report->settings = (object) ['budget' => $budget->id];

        $budgetVsActual = new BudgetVsActual($report);

        return $budgetVsActual->show();
    }

    public function create()
    {
        return view('budgets::create', [
            'periods' => Budget::budgetPeriods(),
            'financial_years' => (new FinancialYear())->getFinancialYears(),
            'is_double_entry_installed' => $this->isDoubleEntryModuleInstalled(),
        ]);
    }

    public function store(BudgetRequest $request)
    {
        $response = $this->ajaxDispatch(new CreateBudget($request));

        if ($response['success']) {
            $response['redirect'] = route('budgets.index');
            $message = trans('messages.success.added', ['type' => trans_choice('budgets::general.budget', 1)]);
            flash($message)->success();
        }

        if ($response['error']) {
            $response['redirect'] = route('budgets.create');
            $message = $response['message'];
            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function edit(Budget $budget)
    {
        $budget->load('budgetedAmounts');

        return view('budgets::edit', [
            'budget' => $budget,
            'periods' => Budget::budgetPeriods(),
            'financial_years' => (new FinancialYear)->getFinancialYears(),
            'is_double_entry_installed' => $this->isDoubleEntryModuleInstalled(),
        ]);
    }

    public function update(BudgetRequest $request, Budget $budget)
    {
        $response = $this->ajaxDispatch(new UpdateBudget($budget, $request));

        if ($response['success']) {
            $response['redirect'] = route('budgets.index');
            $message = trans('messages.success.updated', ['type' => trans_choice('general.budgets', 1)]);
            flash($message)->success();
        }

        if ($response['error']) {
            $response['redirect'] = route('budgets.edit', $budget);
            flash($response['message'])->error()->important();
        }

        return response()->json($response);
    }

    public function destroy(Budget $budget)
    {
        $response = $this->ajaxDispatch(new DeleteBudget($budget));

        if ($response['success']) {
            $response['redirect'] = route('budgets.index');
            $message = trans('messages.success.deleted', ['type' => $budget->name]);
            flash($message)->success();
        }

        if ($response['error']) {
            $message = $response['message'];
            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function accounts()
    {
        if (! $this->isDoubleEntryModuleInstalled()) {
            return new DEClassCollection([]);
        }

        return new DEClassCollection(
            DEClass::query()
                ->where(static function (Builder $query) {
                    $query->where('name', 'double-entry::classes.income')
                         ->orWhere('name', 'double-entry::classes.expenses');
                })
                ->with('accounts')
                ->get()
        );
    }

    public function budgetPeriods(Request $request)
    {
        $budgetPeriod = [];

        if ($request->financial_year && $request->period) {
            $budgetPeriod = (new FinancialYear)->getBudgetPeriod(
                $request->financial_year,
                $request->period
            );
        }

        return response()->json($budgetPeriod);
    }

    private function isDoubleEntryModuleInstalled(): bool
    {
        return Module::alias('double-entry')->enabled()->count() > 0;
    }
}
