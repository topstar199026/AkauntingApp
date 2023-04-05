<?php

namespace Modules\Helpdesk\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request as BasicRequest;
use Modules\Helpdesk\Http\Requests\Ticket as Request;
use Modules\Helpdesk\Jobs\CreateTicket;
use Modules\Helpdesk\Jobs\UpdateTicket;
use Modules\Helpdesk\Jobs\DeleteTicket;
use Modules\Helpdesk\Models\Ticket;
use Modules\Helpdesk\Models\Status;
use Modules\Helpdesk\Models\Priority;
use App\Models\Setting\Category;
use App\Models\Document\Document;
use App\Http\Requests\Common\Import as ImportRequest;
use Modules\Helpdesk\Imports\Tickets as Import;
use Modules\Helpdesk\Exports\Tickets as Export;

class Tickets extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tickets = Ticket::with('category', 'owner', 'assignee', 'status', 'priority')->collect(['created_at' => 'desc']);

        $first_status_id = Status::getFirstStatusID();
        $last_status_id = Status::getLastStatusID();

        return $this->response('helpdesk::tickets.index', compact('tickets', 'first_status_id', 'last_status_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::type('ticket')->orderBy('name')->take(setting('default.select_limit'))->pluck('name', 'id');

        $file_types = $this->getFileTypes();

        $statuses = Status::getAvailableStatuses(0)->pluck('name', 'id');
        $status_id = Status::getFirstStatusID();

        $priorities = Priority::collect()->pluck('name', 'id');
        $priority_id = Priority::getDefaultPriorityID();

        $assignees = company()->users()->collect()->filter(function ($user) {
            return $user->can('update-helpdesk-tickets');
        })->pluck('name', 'id');

        $documents = Document::all()->pluck('document_number', 'id');

        return view('helpdesk::tickets.create', compact(
            'categories',
            'file_types',
            'statuses',
            'status_id',
            'priorities',
            'priority_id',
            'assignees',
            'documents'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $response = $this->ajaxDispatch(new CreateTicket($request));

        if ($response['success']) {
            $response['redirect'] = route('helpdesk.tickets.index');

            $message = trans('messages.success.added', ['type' => trans_choice('helpdesk::general.tickets', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('helpdesk.tickets.create');

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Show the specified resource.
     *
     * @param $ticket
     *
     * @return Response
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('category', 'status', 'priority');

        $limit = (int) request('limit', setting('default.list_limit', '25'));
        $replies = $this->paginate($ticket->replies->sortByDesc('created_at'), $limit);

        $statuses = Status::getAvailableStatuses($ticket->status_id)->pluck('name', 'id');
        $first_status_id = Status::getFirstStatusID();
        $last_status_id = Status::getLastStatusID();

        $priorities = Priority::collect()->pluck('name', 'id');

        $assignees = company()->users()->collect()->filter(function ($user) {
            return $user->can('update-helpdesk-tickets');
        })->pluck('name', 'id');

        return view('helpdesk::tickets.show', compact(
            'ticket',
            'replies',
            'statuses',
            'first_status_id',
            'last_status_id',
            'priorities',
            'assignees'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $ticket
     *
     * @return Response
     */
    public function edit(Ticket $ticket)
    {
        $categories = Category::type('ticket')->orderBy('name')->take(setting('default.select_limit'))->pluck('name', 'id');

        $file_types = $this->getFileTypes();

        $statuses = Status::getAvailableStatuses($ticket->status_id)->pluck('name', 'id');
        $disabled = ($ticket->status_id == Status::getLastStatusID());

        $priorities = Priority::collect()->pluck('name', 'id');

        $assignees = company()->users()->collect()->filter(function ($user) {
            return $user->can('update-helpdesk-tickets');
        })->pluck('name', 'id');

        $documents = Document::all()->pluck('document_number', 'id');

        return view('helpdesk::tickets.edit', compact(
            'ticket',
            'categories',
            'file_types',
            'statuses',
            'disabled',
            'priorities',
            'assignees',
            'documents'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Ticket $ticket
     * @param  Request $request
     *
     * @return Response
     */
    public function update(Ticket $ticket, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdateTicket($ticket, $request));

        if ($response['success']) {
            $response['redirect'] = route('helpdesk.tickets.show', $ticket->id);

            $message = trans('messages.success.updated', ['type' => $ticket->name]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('helpdesk.tickets.edit', $ticket->id);

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  USRequest $request
     *
     * @return Response
     */
    public function updatePartial(int $ticket_id, BasicRequest $request)
    {
        $ticket = Ticket::where('id', $ticket_id)->first();

        $response = $this->ajaxDispatch(new UpdateTicket($ticket, $request));

        $response['redirect'] = route('helpdesk.tickets.show', $ticket->id);

        if ($response['success']) {
            $message = trans('messages.success.updated', ['type' => $ticket->name]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $ticket
     *
     * @return Response
     */
    public function destroy(Ticket $ticket)
    {
        $response = $this->ajaxDispatch(new DeleteTicket($ticket));

        $response['redirect'] = route('helpdesk.tickets.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $ticket->name]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Import the specified resource.
     *
     * @param  ImportRequest  $request
     *
     * @return Response
     */
    public function import(ImportRequest $request)
    {
        $response = $this->importExcel(new Import, $request, trans_choice('helpdesk::general.tickets', 2));

        if ($response['success']) {
            $response['redirect'] = route('helpdesk.tickets.index');

            flash($response['message'])->success();
        } else {
            $response['redirect'] = route('import.create', ['helpdesk', 'tickets']);

            flash($response['message'])->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Export the specified resource.
     *
     * @return Response
     */
    public function export()
    {
        return $this->exportExcel(new Export, trans_choice('helpdesk::general.tickets', 2));
    }

    /**
     * Get supported file types helper
     */
    private function getFileTypes()
    {
        $file_types = [];

        $file_type_mimes = explode(',', config('filesystems.mimes'));

        foreach ($file_type_mimes as $mime) {
            $file_types[] = '.' . $mime;
        }

        return implode(',', $file_types);
    }
}
