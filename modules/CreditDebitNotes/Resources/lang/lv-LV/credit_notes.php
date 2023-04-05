<?php

return [

    'credit_note_number'      => 'Kredīta piezīmes numurs',
    'document_number'         => 'Kredīta piezīmes numurs',
    'credit_note_date'        => 'Kredīta piezīmes datums',
    'issued_at'               => 'Kredīta piezīmes datums',
    'total_price'             => 'Kopējā summa',
    'issue_date'              => 'Izdošanas datums',
    'related_invoice_number'  => 'Rēķina numurs',
    'bill_to'                 => 'Saņēmējs',

    'quantity'                => 'Daudzums',
    'price'                   => 'Cena',
    'sub_total'               => 'Starpsumma',
    'discount'                => 'Atlaide',
    'item_discount'           => 'Rindas atlaide',
    'tax_total'               => 'Nodokļu kopsumma',
    'total'                   => 'Summa',

    'item_name'               => 'Vienuma nosaukums|Vienumu nosaukumi',

    'credit_customer_account' => 'Klienta kredīta konts',
    'show_discount'           => 'Atlaide:discount%',
    'add_discount'            => 'Pievienot atlaidi',
    'discount_desc'           => 'no starpsummas',

    'customer_credited_with'  => ':klients kreditēts ar :summa',
    'credit_cancelled'        => 'kredīta:summa atcelta',
    'refunded_customer_with'  => 'Atmaksātais :klients ar :summu',
    'refund_to_customer'      => 'Atmaksa klientam',

    'histories'               => 'Vēsture',
    'type'                    => 'Veids',
    'credit'                  => 'Kredīts',
    'refund'                  => 'Atmaksa',
    'make_refund'             => 'Veikt atmaksu',
    'mark_sent'               => 'Atzīmēt nosūtīto',
    'mark_viewed'             => 'Atzīmēt skatīto',
    'mark_cancelled'          => 'Atzīme atcelta',
    'download_pdf'            => 'Lejupielādēt PDF',
    'send_mail'               => 'Sūtīt e-pastu',
    'all_credit_notes'        => 'Pierakstīties, lai skatītu visas kredītzīmes',
    'create_credit_note'      => 'Izveidot kredīta piezīmi',
    'send_credit_note'        => 'Nosūtīt kredīta piezīmi',
    'timeline_sent_title'     => 'Nosūtīt kredīta piezīmi',

    'statuses' => [
        'draft'     => 'Melnraksts',
        'sent'      => 'Nosūtīts',
        'viewed'    => 'Skatīts',
        'approved'  => 'Apstiprināts',
        'partial'   => 'Daļējs',
        'cancelled' => 'Atcelts',
    ],

    'messages' => [
        'email_sent'       => 'Kredīta piezīmes e-pasta ziņojums ir nosūtīts!',
        'marked_sent'      => 'Kredīta piezīme atzīmēta kā nosūtīta!',
        'marked_viewed'    => 'Kredīta piezīme atzīmēta kā skatīta!',
        'marked_cancelled' => 'Kredīta piezīme atzīmēta kā atcelta!',
        'refund_was_made'  => 'Atmaksa tika veikta!',
        'email_required'   => 'Šim klientam nav e-pasta adreses!',
        'draft'            => 'Šis ir <b>Melnraksts</b> kredīta notai un tiks atspoguļots diagrammās pēc tā nosūtīšanas.',

        'status' => [
            'created' => 'Izveidots :datums',
            'viewed'  => 'Skatīts',
            'send'    => [
                'draft' => 'Nav nosūtīts',
                'sent'  => 'Nosūtīts :datums',
            ],
        ],
    ],

];
