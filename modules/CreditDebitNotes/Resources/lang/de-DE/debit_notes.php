<?php

return [

    'debit_note_number'           => 'Lieferschein Nummer',
    'document_number'             => 'Lieferschein Nummer',
    'debit_note_date'             => 'Lieferschein Datum',
    'issued_at'                   => 'Lieferschein Datum',
    'total_price'                 => 'Gesamtpreis',
    'issue_date'                  => 'Rechnungsdatum',
    'related_bill_number'         => 'Rechnungsnummer',
    'debit_note_to'               => 'Lieferschein Datum',
    'contact_info'                => 'Lieferschein Datum',

    'quantity'                    => 'Menge',
    'price'                       => 'Preis',
    'sub_total'                   => 'Zwischensumme',
    'discount'                    => 'Rabatt',
    'item_discount'               => 'Positions-Rabatt',
    'tax_total'                   => 'Steuern Total',
    'total'                       => 'Total',

    'item_name'                   => 'Artikelname|Artikelnamen',

    'show_discount'               => ':discount% Rabatt',
    'add_discount'                => 'Rabatt hinzufügen',
    'discount_desc'               => 'von Zwischensumme',

    'refund_from_vendor'          => 'Lieferschein von einem Kreditor',
    'received_refund_from_vendor' => ':amount als Lieferschein von :vendor erhalten',

    'histories'                   => 'Historie',
    'type'                        => 'Typ',
    'refund'                      => 'Lieferschein',
    'mark_sent'                   => 'Als gesendet markieren',
    'receive_refund'              => 'Lieferschein erhalten',
    'mark_viewed'                 => 'Als gelesen markieren',
    'mark_cancelled'              => 'Als storniert markieren',
    'download_pdf'                => 'Als PDF herunterladen',
    'send_mail'                   => 'E-Mail senden',
    'all_debit_notes'             => 'Melden Sie sich an, um alle Lieferscheine anzuzeigen',
    'create_debit_note'           => 'Lieferschein erstellen',
    'send_debit_note'             => 'Lieferschein senden',
    'timeline_sent_title'         => 'Lieferschein senden',

    'statuses' => [
        'draft'     => 'Entwurf',
        'sent'      => 'Versandt',
        'viewed'    => 'Gelesen',
        'cancelled' => 'Storniert',
    ],

    'messages' => [
        'email_sent'          => 'Lieferschein wurde per E-Mail versendet!',
        'marked_viewed'       => 'Lieferschein als <strong>gelesen</strong> markiert!',
        'refund_was_received' => 'Lieferschein wurde erhalten!',
        'email_required'      => 'Es existiert keine E-Mailadresse zu diesem Kreditor!',
        'draft'               => 'Dies ist eine <b>Vorschau</b>-Lieferschein und wird nach dem Versand in den Charts ersichtlich.',

        'status' => [
            'created' => 'Erstellt am :date',
            'viewed'  => 'Gelesen',
            'send'    => [
                'draft' => 'Noch nicht versandt',
                'sent'  => 'Gesendet am :date',
            ],
        ],
    ],

];
