<?php

namespace Modules\Appointments\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Modules\Appointments\Models\Question;
use Modules\Appointments\Jobs\Question\CreateQuestion;
use Modules\Appointments\Jobs\Question\DeleteQuestion;
use Modules\Appointments\Jobs\Question\UpdateQuestion;
use Modules\Appointments\Http\Requests\Question as Request;

class Questions extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $questions = Question::collect();

        foreach ($questions as $question) {
            if ($question->question_type == 0) {
                $question->question_type = trans('appointments::general.text');
            } else {
                $question->question_type = trans('appointments::general.dropdown');
            }
        }

        return $this->response('appointments::questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $question_type = [
            trans('appointments::general.text'),
            trans('appointments::general.dropdown')
        ];

        return view('appointments::questions.create', compact('question_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $response = $this->ajaxDispatch(new CreateQuestion($request));

        if ($response['success']) {
            $response['redirect'] = route('appointments.questions.index');

            $message = trans('messages.success.added', ['type' => trans_choice('appointments::general.name', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('appointments.questions.create');

            flash($response['message'])->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Question  $question
     *
     * @return Response
     */
    public function edit(Question $question)
    {
        $answer = $question->answers;
        if ($question->question_type == 0) {
            $question->question_type = trans('appointments::general.text');
        } else {
            $question->question_type = trans('appointments::general.dropdown');
        }

        $question_type = [
            trans('appointments::general.text'),
            trans('appointments::general.dropdown')
        ];

        return view('appointments::questions.edit', compact('question', 'question_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Question $question
     * @param  Request $request
     *
     * @return Response
     */
    public function update(Question $question, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdateQuestion($question, $request));

        if ($response['success']) {
            $response['redirect'] = route('appointments.questions.index');

            $message = trans('messages.success.updated', ['type' => $question->question]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('appointments.questions.edit', $question->id);

            flash($response['message'])->error()->important();
        }

        return response()->json($response);
    }

        /**
     * Enable the specified resource.
     *
     * @param  Question $appointment
     *
     * @return Response
     */
    public function enable(Question $question)
    {
        $response = $this->ajaxDispatch(new UpdateQuestion($question, request()->merge(['enabled' => 1])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.enabled', ['type' => $question->question]);
        }

        return response()->json($response);
    }

    /**
     * Disable the specified resource.
     *
     * @param  Question $question
     *
     * @return Response
     */
    public function disable(Question $question)
    {
        $response = $this->ajaxDispatch(new UpdateQuestion($question, request()->merge(['enabled' => 0])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.disabled', ['type' => $question->question]);
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Question $question
     *
     * @return Response
    */
    public function destroy(Question $question)
    {
        $response = $this->ajaxDispatch(new DeleteQuestion($question));

        $response['redirect'] = route('appointments.questions.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $question->question]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }
}
