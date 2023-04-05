<?php

namespace Modules\Leaves\Http\Controllers\Settings;

use App\Abstracts\Http\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Leaves\Http\Requests\Year as Request;
use Modules\Leaves\Jobs\Settings\CreateYear;
use Modules\Leaves\Jobs\Settings\DeleteYear;
use Modules\Leaves\Jobs\Settings\UpdateYear;
use Modules\Leaves\Models\Settings\Year;

class Years extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:update-leaves-settings');
    }

    public function index()
    {
        $years = Year::collect();

        return $this->response('leaves::settings.years.index', compact('years'));
    }

    public function create()
    {
        return view('leaves::settings.years.create');
    }

    public function store(Request $request): JsonResponse
    {
        $response = $this->ajaxDispatch(new CreateYear($request));

        if ($response['success']) {
            $response['redirect'] = route('leaves.settings.years.index');

            $message = trans('messages.success.added', ['type' => trans_choice('leaves::general.years', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('leaves.settings.years.create');

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function destroy(Year $year): JsonResponse
    {
        $response = $this->ajaxDispatch(new DeleteYear($year));

        $response['redirect'] = route('leaves.settings.years.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $year->name]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function edit(Year $year)
    {
        return view('leaves::settings.years.edit', compact('year'));
    }

    public function update(Year $year, Request $request): JsonResponse
    {
        $response = $this->ajaxDispatch(new UpdateYear($year, $request));

        if ($response['success']) {
            $response['redirect'] = route('leaves.settings.years.index');

            $message = trans('messages.success.updated', ['type' => $year->name]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('leaves.settings.years.edit', $year->id);

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }
}
