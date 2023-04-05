<?php

namespace Modules\CreditDebitNotes\Http\Controllers\Settings;

use App\Abstracts\Http\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreditNote extends Controller
{
    public array $skip_keys = ['company_id', '_method', '_token', '_prefix'];

    public function edit()
    {
        return view('credit-debit-notes::settings.credit_note');
    }

    public function update(Request $request): JsonResponse
    {
        $fields = $request->all();
        $prefix = $request->get('_prefix', 'credit-debit-notes.credit_note');

        foreach ($fields as $key => $value) {
            $real_key = $prefix . '.' . $key;

            // Don't process unwanted keys
            if (in_array($key, $this->skip_keys)) {
                continue;
            }

            setting()->set($real_key, $value);
        }

        // Save all settings
        setting()->save();

        $message = trans('messages.success.updated', ['type' => trans_choice('general.settings', 2)]);

        $response = [
            'status' => null,
            'success' => true,
            'error' => false,
            'message' => $message,
            'data' => null,
            'redirect' => url()->previous(),
        ];

        flash($message)->success();

        return response()->json($response);
    }
}
