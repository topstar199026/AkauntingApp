<?php

return [

    'title' => 'Шаблони електронних листів',

    'appointment_new_request_customer' => [
        'subject'   => 'Новий користувач',
        'body'      => 'Ваш запит на зустріч отримано<br /><br />Дякуємо за запит на зустріч.<br /><br />Результат вашого запиту на зустріч буде повідомлено вам на електронну пошту.<br /><br />Зв\'яжіться з нами з будь-яким питанням.<br /><br />З найкращими побажаннями,<br />{company_name}',
    ],

    'appointment_paid_request_customer' => [
        'subject'   => 'Плата за зустріч',
        'body'      => 'Шановний {customer_name},<br /><br />Ваш запит на зустріч схвалено<br /><br /><br /><br />Ви можете переглянути деталі платежу за посиленням: <a href="{invoice_guest_link}">{invoice_number}</a>.<br /><br />З найкращими побажаннями,<br />{company_name}',
    ],

    'appointment_detail_customer' => [
        'subject'   => 'Деталі зустрічі',
        'body'      => 'Шановний {customer_name},<br /><br />Ваш процес зустрічі успішно завершено.<br /><br/>Деталі вашої зустрічі:<br /><br />Назва зустрічі: <strong>{appointment_name}</strong><br />Дата зустрічі: <strong>{appointment_date}</strong><br />Час зустрічі: <strong>{appointment_time}</strong><br />Тривалість зустрічі: <strong>{appointment_duration}</strong><br /><br />Зв\'яжіться з нами з будь-яким питанням.<br /><br />З найкращими побажаннями,<br />{company_name}',
    ],

    'appointment_remind_customer'  => [
        'subject'   => 'Нагадування про зустріч',
        'body'      => 'Шановний {customer_name},<br /><br />Час вашої зустрічі наближається.<br /><br />Деталі вашої зустрічі:<br /><br />Назва зустрічі: <strong>{appointment_name}</strong><br />Дата зустрічі: <strong>{appointment_date}</strong><br />Час зустрічі: <strong>{appointment_time}</strong><br />Тривалість зустрічі: <strong>{appointment_duration}</strong><br /><br />Зв\'яжіться з нами з будь-яким питанням.<br /><br />З найкращими побажаннями,<br />{company_name}',
    ],

    'appointment_new_request_admin'   => [
        'subject'   => 'Запит на запрошення отримано',
        'body'      => 'Привіт,<br /><br />Запит на запрошення отримано.<br /><br />Деталі вашої зустрічі:<br /><br />Назва зустручі: <strong>{appointment_name}</strong><br />Дата зустрічі: <strong>{appointment_date}</strong><br />Час зустрічі: <strong>{appointment_time}</strong><br />Ім\'я клієнта: <strong>{customer_name}</strong><br /><br />З найкращими побажаннями,<br />{company_name}',
    ],

    'appointment_remind_admin'   => [
        'subject'   => 'Запит на запрошення отримано',
        'body'      => 'Привіт,<br /><br />Час вашої зустрічі наближається.<br /><br />Деталі вашої зустрічі:<br /><br />Назва зустрічі: <strong>{appointment_name}</strong><br />Дата зустрічі: <strong>{appointment_date}</strong><br />Час зустрічі: <strong>{appointment_time}</strong><br />Ім\'я клієнта: <strong>{customer_name}</strong><br /><br />З найкращими побажаннями,<br />{company_name}',
    ],

    'appointment_remind_employee'   => [
        'subject'   => 'Запит на запрошення отримано',
        'body'      => 'Привіт,<br /><br />Час вашої зустрічі наближається.<br /><br />Деталі вашої зустрічі:<br /><br />Назва зустрічі: <strong>{appointment_name}</strong><br />Дата зустрічі: <strong>{appointment_date}</strong><br />Час зустрічі: <strong>{appointment_time}</strong><br />Ім\'я клієнта: <strong>{customer_name}</strong><br /><br />З найкращими побажаннями,<br />{company_name}',
    ],

];
