<?php

return [

    'title' => 'E-pasta veidnes',

    'appointment_new_request_customer' => [
        'subject'   => 'Jauns klients',
        'body'      => 'Jūsu tikšanās pieprasījums ir saņemts<br /><br />Paldies, ka pieprasījāt tikšanos.<br /><br />Jūsu tikšanās pieprasījuma rezultāts tiks paziņots pa e-pastu.<br /><br />Varat brīvi sazināties ar mums par jebkuru jautājumu.<br /><br />Labākie vēlējumi,<br />{company_name}',
    ],

    'appointment_paid_request_customer' => [
        'subject'   => 'Maksa par tikšanos',
        'body'      => 'Cien. {customer_name},<br /><br />Jūsu tikšanās pieprasījums ir apstiprināts<br /><br /><br /><br />Maksājuma informāciju varat skatīt šajā saitē: <a href="{invoice_guest_link}">{invoice_number}</a>.<br /><br />Labākie vēlējumi,<br />{company_name}',
    ],

    'appointment_detail_customer' => [
        'subject'   => 'Tikšanās dati',
        'body'      => 'Cien.{customer_name},<br /><br />Jūsu tikšanās process ir sekmīgi pabeigts.<br /><br />Jūsu tikšanās dati:<br /><br />Tikšanās nosaukums: <strong>{appointment_name}</strong><br />Tikšanās datums: <strong>{appointment_date}</strong><br />Tikšanās laiks: <strong>{appointment_time}</strong><br />Iecelšanas ilgums: <strong>{appointment_duration}</strong><br /><br />Varat brīvi sazināties ar mums par jebkuru jautājumu.<br /><br />Labākie vēlējumi,<br />{company_name}',
    ],

    'appointment_remind_customer'  => [
        'subject'   => 'Tikšanās atgādinājums',
        'body'      => 'Cien. {customer_name},<br /><br />Tuvojas jūsu tikšanās laiks.<br /><br />Jūsu tikšanās dati:<br /><br />Tikšanās nosaukums: <strong>{appointment_name}</strong><br />Tikšanās datums: <strong>{appointment_date}</strong><br />Tikšanās laiks: <strong>{appointment_time}</strong><br />Tikšanās ilgums: <strong>{appointment_duration}</strong><br /><br />Varat brīvi sazināties ar mums par jebkuru jautājumu.<br /><br />Labākie vēlējumi,<br />{company_name}',
    ],

    'appointment_new_request_admin'   => [
        'subject'   => 'Saņemts tikšanās pieprasījums',
        'body'      => 'Sveiki,<br /><br />Saņemts tikšanās pieprasījums.<br /><br />Jūsu tikšanās dati:<br /><br />Tikšanās nosaukums: <strong>{appointment_name}</strong><br />Tikšanās datums: <strong>{appointment_date}</strong><br />Tikšanās laiks: <strong>{appointment_time}</strong><br />Klienta vārds: <strong>{customer_name}</strong><br /><br />Labākie vēlējumi<br />{company_name}',
    ],

    'appointment_remind_admin'   => [
        'subject'   => 'Saņemts tikšanās pieprasījums',
        'body'      => 'Sveiki,<br /><br />Tuvojas jūsu tikšanās laiks.<br /><br />Your appointment details:<br /><br />Tikšanās nosaukums: <strong>{appointment_name}</strong><br />Tikšanās datums: <strong>{appointment_date}</strong><br />Tikšanās laiks: <strong>{appointment_time}</strong><br />Klienta vārds: <strong>{customer_name}</strong><br /><br />Labākie vēlējumi,<br />{company_name}',
    ],

    'appointment_remind_employee'   => [
        'subject'   => 'Saņemts tikšanās pieprasījums',
        'body'      => 'Sveiki,<br /><br />Tuvojas jūsu tikšanās laiks.<br /><br />Jūsu tikšanās informācija:<br /><br />Tikšanās nosaukums: <strong>{appointment_name}</strong><br />Tikšanās datums: <strong>{appointment_date}</strong><br />Tikšanās laiks: <strong>{appointment_time}</strong><br />Klienta vārds: <strong>{customer_name}</strong><br /><br />Labākie vēlējumi,<br />{company_name}',
    ],

];
