<?php

namespace Modules\CreditDebitNotes\Listeners;

use App\Events\Menu\SettingsCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class ShowInSettingsMenu
{
    use Modules, Permissions;

    public function handle(Event $event)
    {
        if (!$this->moduleIsEnabled('credit-debit-notes')) {
            return;
        }

        $title = trans_choice('credit-debit-notes::general.credit_notes', 1);
        if ($this->canAccessMenuItem($title, 'read-credit-debit-notes-settings-credit-note')) {
            $event->menu->route(
                'credit-debit-notes.settings.credit-note.edit',
                $title,
                [],
                100,
                [
                    'icon'            => 'receipt',
                    'search_keywords' => trans('credit-debit-notes::settings.credit_note.description'),
                ]
            );
        }

        $title = trans_choice('credit-debit-notes::general.debit_notes', 1);
        if ($this->canAccessMenuItem($title, 'read-credit-debit-notes-settings-debit-note')) {
            $event->menu->route(
                'credit-debit-notes.settings.debit-note.edit',
                $title,
                [],
                100,
                [
                    'icon'            => 'request_quote',
                    'search_keywords' => trans('credit-debit-notes::settings.debit_note.description'),
                ]
            );
        }
    }
}
