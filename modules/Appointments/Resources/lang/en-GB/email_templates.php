<?php

return [

    'title' => 'Email Templates',

    'appointment_new_request_customer' => [
        'subject'   => 'New Customer',
        'body'      => 'Your appointment request has been received<br /><br />Thank you for requesting an appointment.<br /><br />The result of your appointment request will be notified to you by e-mail.<br /><br />Feel free to contact us for any question.<br /><br />Best Regards,<br />{company_name}',
    ],

    'appointment_paid_request_customer' => [
        'subject'   => 'Appointment fee',
        'body'      => 'Dear {customer_name},<br /><br />Your appointment request has been approved<br /><br /><br /><br />You can see the payment details from the following link: <a href="{invoice_guest_link}">{invoice_number}</a>.<br /><br />Best Regards,<br />{company_name}',
    ],

    'appointment_detail_customer' => [
        'subject'   => 'Appointment details',
        'body'      => 'Dear {customer_name},<br /><br />Your appointment process has been successfully completed.<br /><br />Your appointment details:<br /><br />Appointment name: <strong>{appointment_name}</strong><br />Appointment date: <strong>{appointment_date}</strong><br />Appointment time: <strong>{appointment_time}</strong><br />Appointment duration: <strong>{appointment_duration}</strong><br /><br />Feel free to contact us for any question.<br /><br />Best Regards,<br />{company_name}',
    ],

    'appointment_remind_customer'  => [
        'subject'   => 'Appointment reminder',
        'body'      => 'Dear {customer_name},<br /><br />Your appointment time is approaching.<br /><br />Your appointment details:<br /><br />Appointment name: <strong>{appointment_name}</strong><br />Appointment date: <strong>{appointment_date}</strong><br />Appointment time: <strong>{appointment_time}</strong><br />Appointment duration: <strong>{appointment_duration}</strong><br /><br />Feel free to contact us for any question.<br /><br />Best Regards,<br />{company_name}',
    ],

    'appointment_new_request_admin'   => [
        'subject'   => 'Appointment request received',
        'body'      => 'Hello,<br /><br />Appointment request received.<br /><br />Your appointment details:<br /><br />Appointment name: <strong>{appointment_name}</strong><br />Appointment date: <strong>{appointment_date}</strong><br />Appointment time: <strong>{appointment_time}</strong><br />Customer name: <strong>{customer_name}</strong><br /><br />Best Regards,<br />{company_name}',
    ],

    'appointment_remind_admin'   => [
        'subject'   => 'Appointment request received',
        'body'      => 'Hello,<br /><br />Your appointment time is approaching.<br /><br />Your appointment details:<br /><br />Appointment name: <strong>{appointment_name}</strong><br />Appointment date: <strong>{appointment_date}</strong><br />Appointment time: <strong>{appointment_time}</strong><br />Customer name: <strong>{customer_name}</strong><br /><br />Best Regards,<br />{company_name}',
    ],

    'appointment_remind_employee'   => [
        'subject'   => 'Appointment request received',
        'body'      => 'Hello,<br /><br />Your appointment time is approaching.<br /><br />Your appointment details:<br /><br />Appointment name: <strong>{appointment_name}</strong><br />Appointment date: <strong>{appointment_date}</strong><br />Appointment time: <strong>{appointment_time}</strong><br />Customer name: <strong>{customer_name}</strong><br /><br />Best Regards,<br />{company_name}',
    ],

];
