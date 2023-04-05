<?php

namespace Modules\Helpdesk\Http\Controllers\Portal;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Response;
use Modules\Helpdesk\Http\Requests\Ticket as Request;
use Modules\Helpdesk\Jobs\CreateTicket;
use Modules\Helpdesk\Models\Ticket;
use Modules\Helpdesk\Models\Status;
use Modules\Helpdesk\Models\Priority;
use App\Models\Setting\Category;
use App\Models\Document\Document;

class Tickets extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tickets = Ticket::isOwner()
            ->with('category', 'status')
            ->collect(['created_at' => 'desc']);

        $t = $tickets->toArray();
        $first_status_id = Status::getFirstStatusID();
        $last_status_id = Status::getLastStatusID();

        return $this->response('helpdesk::portal.tickets.index', compact('tickets', 'first_status_id', 'last_status_id'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function categories()
    {
        $categories = Category::type('ticket')->get();

        return $this->response('helpdesk::portal.categories.index', compact('categories'));
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

        $documents = Document::where('contact_id', user()->contact->id)->pluck('document_number', 'id');

        return view('helpdesk::portal.tickets.create', compact(
            'categories',
            'file_types',
            'statuses',
            'status_id',
            'priorities',
            'priority_id',
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
            $response['redirect'] = route('portal.helpdesk.tickets.index');

            $message = trans('messages.success.added', ['type' => trans_choice('helpdesk::general.tickets', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('portal.helpdesk.tickets.create');

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @return Response
     */
    public function show(Ticket $ticket)
    {
        if (! user()->owns($ticket)) {
            // In case the URL is directly accessed
            abort(403);
        }

        $ticket->load('category', 'status');

        $limit = (int) request('limit', setting('default.list_limit', '25'));
        $replies = $this->paginate($ticket->replies->where('internal', false)->sortByDesc('created_at'), $limit);

        $file_types = $this->getFileTypes();

        $first_status_id = Status::getFirstStatusID();
        $last_status_id = Status::getLastStatusID();

        return view('helpdesk::portal.tickets.show', compact('ticket',
            'replies',
            'file_types',
            'first_status_id',
            'last_status_id'
        ));
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
