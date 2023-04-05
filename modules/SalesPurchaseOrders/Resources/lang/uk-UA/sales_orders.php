<?php

return [
    'description'                => 'Налаштуйте префікс замовлення на продаж, номер, умови, нижній колонтитул тощо',
    'invoice_number'             => 'Номер замовлення на продаж',
    'invoice_date'               => 'Дата замовлення на продаж',
    'expected_shipment_date'     => 'Очікувана дата відправлення',
    'order_number'               => 'Посилання',
    'create_sales_order'         => 'Створити замовлення на продаж',
    'send_invoice'               => 'Надіслати замовлення на продаж',
    'amount_due'                 => 'Сума',
    'confirm_sales_orders'       => 'Підтвердити замовлення на продаж',
    'mark_confirmed'             => 'Позначку погоджено',
    'convert_to_invoice'         => 'Перетворити в рахунок-фактуру',
    'convert_to_purchase_order'  => 'Конвертувати замовлення на купівлю',
    'summary_report_type'        => 'Підсумок замовлення на продаж',
    'summary_report_description' => 'Підсумок місячних замовлень на продаж від продавців',
    'messages'                   => [
        'draft' => 'Це замовлення на продаж <b>ПРОЄКТА</b> буде зображено в графіках після його отримання.',
    ],
    'statuses'                   => [
        'draft'         => 'Проєкт',
        'sent'          => 'Надісланий',
        'invoiced'      => 'Встановлено рахунок',
        'not_invoiced'  => 'Не встановлено рахунку',
        'confirmed'     => 'Підтверджено',
        'not_confirmed' => 'Не підтверджено',
        'cancelled'     => 'Скасовано',
    ],
];