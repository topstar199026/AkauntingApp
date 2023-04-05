<?php

namespace Modules\Proposals\Http\Controllers\Portal;

use App\Abstracts\Http\Controller;
use App\Traits\Documents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Estimates\Events\Approved;
use Modules\Estimates\Events\Refused;
use Modules\Proposals\Models\Proposal;
use Modules\Proposals\Models\ProposalPipeline;

class Proposals extends Controller
{
    use Documents;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $proposals = Proposal::with(['estimate'])->companyId(company_id())->whereHas('estimate', function (Builder $query) {
            $query->where('contact_id', user()->contact->id);
        })->collect();

        return view('proposals::portal.proposals.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return redirect()->route('portal.proposals.proposals.index');
    }

    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store()
    {
        return redirect()->route('portal.proposals.proposals.index');
    }

    /**
     * Show the specified resource.
     * @param Proposal $proposal
     * @return Response
     */
    public function show(Proposal $proposal)
    {
        $content_html = $proposal->content_html;
        $content_css = $proposal->content_css;

        return view('proposals::portal.proposals.show', compact('content_html', 'content_css', 'proposal'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return redirect()->route('portal.proposals.proposals.index');
    }

    /**
     * Update the specified resource in storage.
     * @return Response
     */
    public function update()
    {
        return redirect()->route('portal.proposals.proposals.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
        return redirect()->route('portal.proposals.proposals.index');
    }

    /**
     * Download proposal as pdf
     * @param Proposal $proposal
     * @return Response
     */
    public function download(Proposal $proposal)
    {
        $content_html = $proposal->content_html;
        $content_css = $proposal->content_css;

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('proposals::proposals.pdf', compact('content_html', 'content_css'));

        return $pdf->download("proposal_{$proposal->id}.pdf");
    }

    /**
     * Marks refused related estimate.
     * @param Proposal $proposal
     * @return Response
     */
    public function refuse(Proposal $proposal)
    {
        if (module('estimates') && $proposal->estimate()->first()) {
            event(new Refused($proposal->estimate()->first()));

            $message = trans(
                'documents.messages.marked_as',
                [
                    'type'   => trans_choice('estimates::general.estimates', 1),
                    'status' => Str::lower(trans('documents.statuses.refused')),str()
                ]
            );
    
            flash($message)->success();
        }

        if (module('crm') && $proposal->deal()->first()) {
            $deal = $proposal->deal()->first();

            if ($deal) {
                $stage = ProposalPipeline::companyId($deal->company_id)->where('pipeline_id', $deal->pipeline_id)->first()->stage_id_refused;

                if ($stage != null) {
                    $deal->stage_id = $stage;
                }

                $deal->save();
            }
        }

        return redirect()->route('portal.proposals.proposals.index');
    }

    /**
     * Marks approved related estimate.
     * @param Proposal $proposal
     * @return Response
     */
    public function approve(Proposal $proposal)
    {
        if (module('estimates') && $proposal->estimate()->first()) {
            event(new Approved($proposal->estimate()->first()));

            $message = trans(
                'documents.messages.marked_as',
                [
                    'type'   => trans_choice('estimates::general.estimates', 1),
                    'status' => Str::lower(trans('documents.statuses.approved')),
                ]
            );
    
            flash($message)->success();
        }

        if (module('crm') && $proposal->deal()->first()) {
            $deal = $proposal->deal()->first();

            if ($deal) {
                $stage = ProposalPipeline::companyId($deal->company_id)->where('pipeline_id', $deal->pipeline_id)->first()->stage_id_approve;

                if ($stage != null) {
                    $deal->stage_id = $stage;
                }

                $deal->save();
            }
        }

        return redirect()->route('portal.proposals.proposals.index');
    }
}
