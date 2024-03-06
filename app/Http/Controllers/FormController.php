<?php

namespace App\Http\Controllers;

use App\Requests\FormRequest;
use Illuminate\Http\Request;
use Exception;

class FormController extends Controller
{
    public function __construct(
        protected FormRequest $formRequest
    )
    {}

    public function returnStatusMessage(Request $request)
    {
        try {
            $data = $request->all();

            if (!$request->hasFile('file')) {
                throw new Exception(__('messages.error.file_required'));
            }

            $data['file'] = $request->file('file');

            if (!$this->formRequest->formRequest($data)) {
                throw new Exception(__('messages.error.validation_failed'));
            }

            return response()->json(['status' => 'success', 'message' => __('messages.error.send_message')]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}
