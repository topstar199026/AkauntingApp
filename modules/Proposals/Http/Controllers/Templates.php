<?php

namespace Modules\Proposals\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Response;
use Modules\Proposals\Http\Requests\TemplateRequest;
use Modules\Proposals\Jobs\Templates\CreateTemplate;
use Modules\Proposals\Jobs\Templates\DeleteTemplate;
use Modules\Proposals\Jobs\Templates\UpdateTemplate;
use Modules\Proposals\Models\Template;

class Templates extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $templates = Template::collect();

        return view('proposals::templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('proposals::templates.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param TemplateRequest $request
     * @return Response
     */
    public function store(TemplateRequest $request)
    {
        $response = $this->ajaxDispatch(new CreateTemplate($request));

        if ($response['success']) {
            $response['redirect'] = route('proposals.templates.index');

            $message = trans('messages.success.added', ['type' => trans_choice('general.templates', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('proposals.templates.create');

            $message = $response['message'];

            flash($message)->error();
        }

        return response()->json($response);
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
     * @param Template $template
     * @return Response
     */
    public function edit(Template $template)
    {
        return view('proposals::templates.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     * @param Template $template
     * @param TemplateRequest $request
     * @return Response
     */
    public function update(Template $template, TemplateRequest $request)
    {
        $response = $this->ajaxDispatch(new UpdateTemplate($template, $request));

        if ($response['success']) {
            $response['redirect'] = route('proposals.templates.index');

            $message = trans('messages.success.updated', ['type' => $template->name]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('proposals.templates.edit', $template->id);

            $message = $response['message'];

            flash($message)->error();
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     * @param Template $template
     * @return Response
     */
    public function destroy(Template $template)
    {
        $response = $this->ajaxDispatch(new DeleteTemplate($template));

        $response['redirect'] = route('proposals.templates.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $template->name]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error();
        }

        return response()->json($response);
    }

    /**
     * Duplicating the resource.
     * @param Template $template
     * @return Response
     */
    public function duplicate(Template $template)
    {
        $clone = $template->duplicate();

        $message = trans('messages.success.duplicated', ['type' => trans_choice('general.templates', 1)]);

        flash($message)->success();

        return redirect()->route('proposals.templates.edit', $clone->id);
    }

    /**
     * Fetch content of template.
     * @param Template $template
     * @return Response
     */
    public function content(Template $template)
    {
        $response['content_html'] = $template->content_html;
        $response['content_css'] = $template->content_css;
        $response['content_components'] = $template->content_components;
        $response['content_style'] = $template->content_style;

        return response()->json($response);
    }

    /**
     * Download template as pdf
     * @param Template $template
     * @return Response
     */
    public function download(Template $template)
    {
        $content_html = $template->content_html;
        $content_css = $template->content_css;

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('proposals::templates.pdf', compact('content_html', 'content_css'));

        return $pdf->download("template_{$template->id}.pdf");
    }
}
