<?php

return [

    'debit_note_number'           => 'Номер дебетового авізо',
    'document_number'             => 'Номер дебетового авізо',
    'debit_note_date'             => 'Номер дебетового авізо',
    'issued_at'                   => 'Номер дебетового авізо',
    'total_price'                 => 'Загальна сума',
    'issue_date'                  => 'Дата випуску',
    'related_bill_number'         => 'Номер рахунку',
    'debit_note_to'               => 'Дебетове авізо до',
    'contact_info'                => 'Дебетове авізо до',

    'quantity'                    => 'Кількість',
    'price'                       => 'Ціна',
    'sub_total'                   => 'Підсумок',
    'discount'                    => 'Знижка',
    'item_discount'               => 'Лінійна знижка',
    'tax_total'                   => 'Сума податку',
    'total'                       => 'Загалом',

    'item_name'                   => 'Назва товару|Назви товару',

    'show_discount'               => ':discount% Знижка',
    'add_discount'                => 'Додати знижку',
    'discount_desc'               => 'з проміжного підсумка',

    'refund_from_vendor'          => 'Повернення коштів від продавця',
    'received_refund_from_vendor' => 'Отримано :amount як відшкодування від :vendor',

    'histories'                   => 'Історії',
    'type'                        => 'Тип',
    'refund'                      => 'Повернення коштів',
    'mark_sent'                   => 'Позначити відправленим',
    'receive_refund'              => 'Отримати відшкодування',
    'mark_viewed'                 => 'Позначити як переглянуто',
    'mark_cancelled'              => 'Позначити як скасовано',
    'download_pdf'                => 'Завантажити PDF',
    'send_mail'                   => 'Надіслати електронного листа',
    'all_debit_notes'             => 'Увійти, щоб переглянути всі дебетові авізо',
    'create_debit_note'           => 'Створити Дебетове авізо',
    'send_debit_note'             => 'Надіслати Дебетове авізо',
    'timeline_sent_title'         => 'Надіслати Дебетове авізо',

    'statuses' => [
        'draft'     => 'Проєкт',
        'sent'      => 'Надісланий',
        'viewed'    => 'Переглянуто',
        'cancelled' => 'Скасовано',
    ],

    'messages' => [
        'email_sent'          => 'Електронний лист із дебетовим авізо надіслано!',
        'marked_viewed'       => 'Електронний лист із дебетовим авізо переглянуте!',
        'refund_was_received' => 'Відшкодування отримано!',
        'email_required'      => 'Немає електронної адреси для цього клієнта!',
        'draft'               => 'Це дебетове авізо <b>ПРОЄКТ</b> буде показуватися на графіках після його отримання.',

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
