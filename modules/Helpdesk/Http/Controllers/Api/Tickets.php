<?php

namespace Modules\Helpdesk\Http\Controllers\Api;

use App\Abstracts\Http\ApiController;
use Modules\Helpdesk\Http\Requests\Ticket as Request;
use Modules\Helpdesk\Http\Resources\Ticket as Resource;
use Modules\Helpdesk\Jobs\CreateTicket;
use Modules\Helpdesk\Jobs\DeleteTicket;
use Modules\Helpdesk\Jobs\UpdateTicket;
use Modules\Helpdesk\Models\Ticket;

class Tickets extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tickets = Ticket::with('category', 'replies')->collect();

        return Resource::collection($tickets);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $ticket = Ticket::with('category', 'replies')->find($id);

        return new Resource($ticket);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $ticket = $this->dispatch(new CreateTicket($request));

        return $this->created(route('api.helpdesk.tickets.show', $ticket->id), new Resource($ticket));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $ticket
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Ticket $ticket, Request $request)
    {
        $ticket = $this->dispatch(new UpdateTicket($ticket, $request));

        return new Resource($ticket->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::with('replies')->find($id);

        if ($ticket !== null) {
            try {
                $this->dispatch(new DeleteTicket($ticket));
                return $this->noContent();
            } catch (\Exception $e) {
                $this->errorUnauthorized($e->getMessage());
            }
        } else {
            return $this->errorNotFound();
        }
    }
}
