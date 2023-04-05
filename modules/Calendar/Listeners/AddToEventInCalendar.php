<?php

namespace Modules\Calendar\Listeners;

use App\Models\Banking\Transaction;
use App\Models\Document\Document;
use App\Utilities\Recurring;
use App\Utilities\Date;
use Modules\Calendar\Events\CalendarEventCreated as Event;
use Modules\Calendar\Traits\Calendar;

class AddToEventInCalendar
{
    use Calendar;

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(Event $event)
    {        
        if (user()->canAny('read-sales-invoices')) {
            $invoices = $this->applyFilters(Document::invoice()->with('recurring', 'transactions')->accrued(), ['date_field' => 'due_at'])->get();

            $this->addEvents($event, $this->forRecurring($invoices),[
                'start' => 'due_at',
                'type' => 'invoice',
                'color' => '#4D4F7D',
                'background_color' => '#EEEEF3',
                'title' => 'document_number',
                'show_path' => 'invoices.show',
                'edit_path' => 'invoices.edit'
            ]);
        }

        if (user()->canAny('read-purchases-bills')) {
            $bills = $this->applyFilters(Document::bill()->with('recurring', 'transactions')->accrued(), ['date_field' => 'due_at'])->get();

            $this->addEvents($event, $this->forRecurring($bills),[
                'start' => 'due_at',
                'type' => 'bill',
                'color' => '#B80000',
                'background_color' => '#EB9999',
                'title' => 'document_number',
                'show_path' => 'bills.show',
                'edit_path' => 'bills.edit'
            ]);
        }

        if (user()->canAny('read-banking-transactions')) {
            foreach (['income', 'expense'] as $type) {
                $transactions = $this->applyFilters(Transaction::with('category')->$type()->isNotTransfer())->get();

                $this->addEvents($event, $transactions,[
                    'start' => 'paid_at',
                    'type' => $type,
                    'title' => 'number',
                    'show_path' => 'transactions.show',
                    'edit_path' => 'transactions.edit'
                ]);
            }
        }
    }

    protected function forRecurring($items)
    {
        Recurring::reflect($items, 'issued_at');
        foreach ($items as $item) {
            if ($item->parent_id != 0) {
                if ($item->issued_at->isPast() && $item->created_from != 'core::recurring') {
                    continue;
                }
            }

            $recurring[] = $item;
        }

        return isset($recurring) ? collect($recurring) : [];
    }

    protected function addEvents($event, $items, $attribute)
    {
        $attribute_start = $attribute['start'];
        $attribute_title = $attribute['title'];

        foreach ($items as $item) {
            $background_color = isset($attribute['background_color']) ? $attribute['background_color'] : $item->category->color;
            $title = $item->$attribute_title ?? $attribute_title;

            if (isset($item->status) && ($item->type == 'invoice' || $item->type == 'bill') ? true : false) {
                $start = $item->status == 'paid' ? Date::parse($item->issued_at)->format('Y-m-d') : Date::parse($item->due_at)->format('Y-m-d');
            } else {
                $start = Date::parse($item->$attribute_start)->format('Y-m-d');
            }

            $event->calendar->events[] = [
                'id'                => $item->id,
                'title'             => $title,
                'start'             => $start,
                'type'              => $attribute['type'],
                'textColor'         => $attribute['color'] ?? null,
                'backgroundColor'   => $background_color,
                'borderColor'       => $background_color,
                'extendedProps' => [
                    'show'          => route($attribute['show_path'], $item->id),
                    'edit'          => route($attribute['edit_path'], $item->id),
                    'description'   => $item->description . trans('calendar::general.event_description', ['url' => route($attribute['show_path'], $item->id), 'name' => $title]),
                    'date'          => $start
                ],
            ];
        }
    }
}
