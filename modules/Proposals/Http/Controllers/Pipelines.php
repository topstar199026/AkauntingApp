<?php

namespace Modules\Proposals\Http\Controllers;

use App\Abstracts\Http\Controller;
use App\Traits\Modules;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Proposals\Jobs\Pipelines\UpdatePipeline;
use Modules\Proposals\Models\ProposalPipeline;

class Pipelines extends Controller
{
    use Modules;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $pipelines = ProposalPipeline::collect();

        if ($this->moduleIsEnabled('crm')) {
            $pipelines = ProposalPipeline::with(['pipeline'])->collect();
        }

        return view('proposals::pipelines.index', compact('pipelines'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param ProposalPipeline $pipeline
     * @return Response
     */
    public function edit(ProposalPipeline $pipeline)
    {
        $stages = $pipeline->pipeline()
            ->first()
            ->stages
            ->pluck('name', 'id');

        return view('proposals::pipelines.edit', compact('pipeline', 'stages'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ProposalPipeline $pipeline, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdatePipeline($pipeline, $request));

        if ($response['success']) {
            $response['redirect'] = route('proposals.pipelines.index');

            $message = trans('messages.success.updated', ['type' => $pipeline->pipeline()->first()->name]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('proposals.pipelines.edit', $pipeline->id);

            $message = $response['message'];

            flash($message)->error();
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
