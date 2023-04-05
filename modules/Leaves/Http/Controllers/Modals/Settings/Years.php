<?php

namespace Modules\Leaves\Http\Controllers\Modals\Settings;

use App\Abstracts\Http\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Leaves\Http\Requests\Year as Request;
use Modules\Leaves\Jobs\Settings\CreateYear;

class Years extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:update-leaves-settings');
    }

    public function create(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'error'   => false,
            'message' => 'null',
            'html'    => view('leaves::modals.settings.years.create')->render(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $response = $this->ajaxDispatch(new CreateYear($request));

        if ($response['success']) {
            $response['message'] = trans('messages.success.added', ['type' => trans('leaves::general.leave_year')]);
        }

        return response()->json($response);
    }
}
