<?php

return [

    'credit_note_number'      => 'Номер кредитового авізо',
    'document_number'         => 'Номер кредитового авізо',
    'credit_note_date'        => 'Дата кредитового авізо',
    'issued_at'               => 'Дата кредитового авізо',
    'total_price'             => 'Загальна сума',
    'issue_date'              => 'Дата випуску',
    'related_invoice_number'  => 'Номер рахунку-фактури',
    'bill_to'                 => 'Рахунок до',

    'quantity'                => 'Кількість',
    'price'                   => 'Ціна',
    'sub_total'               => 'Проміжний підсумок',
    'discount'                => 'Знижка',
    'item_discount'           => 'Лінійна знижка',
    'tax_total'               => 'Сума податку',
    'total'                   => 'Загалом',

    'item_name'               => 'Назва товару|Назви товару',

    'credit_customer_account' => 'Кредитний рахунок клієнта',
    'show_discount'           => ':discount% Знижка',
    'add_discount'            => 'Додати знижку',
    'discount_desc'           => 'проміжний підсумок',

    'customer_credited_with'  => ':customer нараховує :amount',
    'credit_cancelled'        => ':amount кредиту скасовано',
    'refunded_customer_with'  => 'Повернено :customer з :amount',
    'refund_to_customer'      => 'Повернення коштів клієнту',

    'histories'               => 'Історії',
    'type'                    => 'Тип',
    'credit'                  => 'Кредит',
    'refund'                  => 'Повернення коштів',
    'make_refund'             => 'Здійснити повернення коштів',
    'mark_sent'               => 'Позначити надісланим',
    'mark_viewed'             => 'Позначити як переглянуто',
    'mark_cancelled'          => 'Позначити як скасовано',
    'download_pdf'            => 'Завантажити PDF',
    'send_mail'               => 'Надіслати електронного листа',
    'all_credit_notes'        => 'Увійдіть, щоб переглянути всі кредитні авізо',
    'create_credit_note'      => 'Створити Кредитове авізо',
    'send_credit_note'        => 'Надіслати Кредитове авізо',
    'timeline_sent_title'     => 'Надіслати Кредитове авізо',

    'statuses' => [
        'draft'     => 'Проєкт',
        'sent'      => 'Надісланий',
        'viewed'    => 'Переглянуто',
        'approved'  => 'Затверджено',
        'partial'   => 'Частково',
        'cancelled' => 'Скасовано',
    ],

    'messages' => [
        'email_sent'       => 'Електронний лист із кредитовим авізо надіслано!',
        'marked_sent'      => 'Кредитове авізо позначено як надіслане!',
        'marked_viewed'    => 'Кредитове авізо позначено як переглянуте!',
        'marked_cancelled' => 'Кредитове авізо позначено як скасоване!',
        'refund_was_made'  => 'Повернення коштів здійснено!',
        'email_required'   => 'Немає електронної адреси для цього клієнта!',
        'draft'            => 'Це кредитове авізо <b>ПРОЄКТ</b> відображатиметься на графіках після його отримання.',

        'status' => [
            'created' => 'Створено :date',
            'viewed'  => 'Переглянуто',
            'send'    => [
                'draft' => 'Не надіслано',
                'sent'  => 'Надіслано :date',
            ],
        ],
    ],

];
