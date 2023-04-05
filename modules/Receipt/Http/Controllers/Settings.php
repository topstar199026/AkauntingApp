<?php

namespace Modules\Receipt\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Receipt\Traits\Api;

class Settings extends Controller
{
    use Api;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit()
    {
        $platforms = [
            'taggun' => 'Taggun',
            'mindee' => 'Mindee'
        ];

        $api_key = setting('receipt.api_key', '');

        return view('receipt::settings.edit', compact('api_key', 'platforms'));
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $message = trans('messages.success.updated', ['type' => trans_choice('general.settings', 2)]);

        $response = [
            'success' => true,
            'error' => false,
            'message' => $message,
            'redirect' => route('receipt.index'),
        ];

        switch ($request['platform']) {
            case 'mindee':
                $checkStatus = $this->checkMindee('https://akaunting.com/public/images/logo-dark.png', $request['api_key']);

                if ($checkStatus != 201) {
                    $response['success'] = false;
                    $response['error'] = true;
                    $response['message'] = $message = trans('receipt::general.unauthorized', ['type' => trans_choice('general.settings', 2)]);
                    $response['redirect'] = route('receipt.setting');

                    flash($message)->error();
                    return response()->json($response);
                }
            case 'taggun':
        }

        setting()->set('receipt.api_key', $request['api_key']);
        setting()->set('receipt.platform', $request['platform']);
        setting()->save();

        flash($message)->success();

        return response()->json($response);
    }
}
