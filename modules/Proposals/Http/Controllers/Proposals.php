<?php

namespace Modules\Proposals\Http\Controllers;

use App\Abstracts\Http\Controller;
use App\Models\Setting\Currency;
use App\Traits\Modules;
use Illuminate\Http\Response;
use Modules\Crm\Jobs\CreateDeal;
use Modules\Crm\Models\Company;
use Modules\Crm\Models\Contact;
use Modules\Crm\Models\DealPipeline;
use Modules\Estimates\Models\Estimate;
use Modules\Proposals\Http\Requests\ProposalRequest;
use Modules\Proposals\Jobs\Proposals\CreateProposal;
use Modules\Proposals\Jobs\Proposals\DeleteProposal;
use Modules\Proposals\Jobs\Proposals\UpdateProposal;
use Modules\Proposals\Models\Proposal;
use Modules\Proposals\Models\ProposalPipeline;
use Modules\Proposals\Models\Template;
use Modules\Proposals\Notifications\Proposal as ProposalNotification;

class Proposals extends Controller
{
    use Modules;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $module_estimates = $this->moduleIsEnabled('estimates');
        $module_crm = $this->moduleIsEnabled('crm');

        if (!$module_estimates && !$module_crm) {
            $proposals = Proposal::collect();

            return view('proposals::proposals.index', compact('proposals', 'module_estimates', 'module_crm'));
        }

        if ($module_estimates) {
            $relations = ['estimate'];
        }

        if ($module_crm) {
            $relations = ['deal'];
        }

        if ($module_estimates && $module_crm) {
            $relations = ['estimate', 'deal'];
        }

        $proposals = Proposal::with($relations)->collect();

        return view('proposals::proposals.index', compact('proposals', 'module_estimates', 'module_crm'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $estimates = null;
        $contacts = null;
        $companies = null;
        $pipelines = null;
        $owners = null;
        $currency = null;

        $templates = Template::all()
            ->pluck('name', 'id');

        $module_estimates = $this->moduleIsEnabled('estimates');

        if ($module_estimates) {
            $estimates = Estimate::estimate()
                ->notInvoiced()
                ->get()
                ->pluck('document_number', 'id');
        }

        $module_crm = $this->moduleIsEnabled('crm');

        if ($module_crm) {
            $contacts = Contact::with('contact')
                ->enabled()
                ->get()
                ->pluck('name', 'id');

            $companies = Company::with('contact')
                ->enabled()
                ->get()
                ->pluck('name', 'id');

            $pipelines = DealPipeline::get()->pluck('name', 'id');

            $owners = company()->users()->pluck('name', 'id');

            $currency = Currency::where('code', setting('default.currency'))->first();
        }

        return view('proposals::proposals.create', compact('templates', 'estimates', 'contacts', 'companies', 'pipelines', 'owners', 'currency', 'module_estimates', 'module_crm'));
    }

    /**
     * Store a newly created resource in storage.
     * @param ProposalRequest $request
     * @return Response
     */
    public function store(ProposalRequest $request)
    {
        $response = $this->ajaxDispatch(new CreateProposal($request));

        if ($response['success']) {
            $response['redirect'] = route('proposals.proposals.index');

            $message = trans('messages.success.added', ['type' => trans_choice('proposals::general.proposals', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('proposals.proposals.create');

            $message = $response['message'];

            flash($message)->error();
        }

        if ($response['success'] && $this->moduleIsEnabled('crm') && request('create_deal') == 'true') {
            $deal_request = [
                'company_id' => $request->company_id,
                'crm_contact_id' => $request->crm_contact_id,
                'crm_company_id' => $request->crm_company_id,
                'pipeline_id' => $request->pipeline_id,
                'name' => $request->name,
                'amount' => $request->amount,
                'owner_id' => $request->owner_id,
                'color' => $request->color,
                'closed_at' => $request->closed_at,
                'created_by' => user()->id,
            ];

            $deal_response = $this->ajaxDispatch(new CreateDeal($deal_request));

            if ($deal_response['success']) {
                $proposal = $response['data'];
                $proposal->deal_id = $deal_response['data']->id;
                $proposal->save();

                $deal_message = trans('messages.success.added', ['type' => trans_choice('crm::general.deals', 1)]);

                flash($deal_message)->success();
            } else {
                $deal_message = $deal_response['message'];

                flash($deal_message)->error();
            }
        }

        return response()->json($response);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Proposal $proposal)
    {
        return redirect()->route('proposals.proposals.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Proposal $proposal
     * @return Response
     */
    public function edit(Proposal $proposal)
    {
        $templates = Template::all()->pluck('name', 'id');
        $estimates = null;

        if ($this->moduleIsEnabled('estimates')) {
            $estimates = Estimate::estimate()
                ->all()
                ->pluck('document_number', 'id');
        }

        return view('proposals::proposals.edit', compact('proposal', 'estimates', 'templates'));
    }

    /**
     * Update the specified resource in storage.
     * @param Proposal $proposal
     * @param ProposalRequest $request
     * @return Response
     */
    public function update(Proposal $proposal, ProposalRequest $request)
    {
        $response = $this->ajaxDispatch(new UpdateProposal($proposal, $request));

        if ($response['success']) {
            $response['redirect'] = route('proposals.proposals.index');

            $message = trans('messages.success.updated', ['type' => $proposal->description]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('proposals.proposals.edit', $proposal->id);

            $message = $response['message'];

            flash($message)->error();
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     * @param Proposal $proposal
     * @return Response
     */
    public function destroy(Proposal $proposal)
    {
        $response = $this->ajaxDispatch(new DeleteProposal($proposal));

        $response['redirect'] = route('proposals.proposals.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $proposal->description]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error();
        }

        return response()->json($response);
    }

    /**
     * Duplicating the resource.
     * @param Proposal $proposal
     * @return Response
     */
    public function duplicate(Proposal $proposal)
    {
        $clone = $proposal->duplicate();

        $message = trans('messages.success.duplicated', ['type' => trans_choice('proposals::general.proposals', 1)]);

        flash($message)->success();

        return redirect()->route('proposals.edit', $clone->id);
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
     * Notify contact on estimate
     * @param Proposal $proposal
     * @return Response
     */
    public function notify(Proposal $proposal)
    {
        if ($this->moduleIsEnabled('estimates')) {
            $estimate = $proposal->estimate()->first();

            if ($estimate) {
                if ($estimate->contact && !empty($estimate->contact_email)) {
                    $estimate->contact->notify(new ProposalNotification($proposal, $estimate, 'proposal_send_customer'));

                    $message = trans('proposals::general.email_sent');

                    flash($message)->success();
                }
            }
        }

        if ($this->moduleIsEnabled('crm')) {
            $is_sent_deal_mail = 0;
            $deal = $proposal->deal()->first();

            if ($deal) {
                if ($deal->contact->contact && !empty($deal->contact->contact->email)) {
                    $deal->contact->contact->notify(new ProposalNotification($proposal, $deal, 'proposal_send_customer'));

                    $is_sent_deal_mail = 1;
                    $message = trans('proposals::general.email_sent');

                    flash($message)->success();
                }

                if ($deal->company->contact && !empty($deal->company->contact->email)) {
                    $deal->company->contact->notify(new ProposalNotification($proposal, $deal, 'proposal_send_customer'));

                    $is_sent_deal_mail = 1;
                    $message = trans('proposals::general.email_sent');

                    flash($message)->success();
                }
            }

            if ($is_sent_deal_mail) {
                $stage = ProposalPipeline::companyId($deal->company_id)->where('pipeline_id', $deal->pipeline_id)->first()->stage_id_send;

                if ($stage != null) {
                    $deal->stage_id = $stage;
                }

                $deal->save();
            }
        }

        return redirect()->back();
    }
}
