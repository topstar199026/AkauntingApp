<?php

return [

    'title'                    => 'Plantillas De Correo Electrónico',
    'appointment_new_request_customer' => [
        'subject' => 'Nuevo cliente',
        'body' => 'Su solicitud de cita ha sido recibida<br /><br />Gracias por solicitar una cita.<br /><br />El resultado de su solicitud de cita le será notificado por correo electrónico.<br /><br />No dude en contactar con nosotros para cualquier pregunta.<br /><br />Saludos cordiales,<br />{company_name}',
    ],

    'appointment_paid_request_customer' => [
        'subject' => 'Página de cita',
        'body'    => 'Estimado {customer_name},<br /><br />Su solicitud de cita ha sido aprobada<br /><br /><br /><br />Puede ver los detalles del pago desde el siguiente enlace: <a href="{invoice_guest_link}">{invoice_number}</a>.<br /><br />Saludos cordiales,<br />{company_name}',
    ],

    'appointment_detail_customer' => [
        'subject' => 'Fecha de la cita',
        'body'    => 'Estimado {customer_name},<br /><br />El proceso de su cita se ha completado correctamente.<br /><br />Detalles de la cita:<br /><br />Nombre de la cita: <strong>{appointment_name}</strong><br />Fecha de la cita: <strong>{appointment_date}</strong><br />Hora de la cita: <strong>{appointment_time}</strong><br />Duración de la cita: <strong>{appointment_duration}</strong><br /><br />No dude en ponerse en contacto con nosotros para cualquier pregunta.<br /><br />Saludos cordiales,<br />{company_name}',
    ],

    'appointment_remind_customer'  => [
        'subject' => 'Recordatorio de cita',
        'body'    => 'Estimado {customer_name},<br /><br />El proceso de su cita se ha completado correctamente.<br /><br />Detalles de la cita:<br /><br />Nombre de la cita: <strong>{appointment_name}</strong><br />Fecha de la cita: <strong>{appointment_date}</strong><br />Hora de la cita: <strong>{appointment_time}</strong><br />Duración de la cita: <strong>{appointment_duration}</strong><br /><br />No dude en ponerse en contacto con nosotros para cualquier pregunta.<br /><br />Saludos cordiales,<br />{company_name}',
    ],

    'appointment_new_request_admin'   => [
        'subject' => 'Solicitud de cita recibida',
        'body'    => 'Hola,<br /><br />Solicitud de cita recibida.<br /><br />Detalles de la cita:<br /><br />Nombre de la cita: <strong>{appointment_name}</strong><br />Fecha de la cita: <strong>{appointment_date}</strong><br />Hora de la cita: <strong>{appointment_time}</strong><br />Nombre del cliente: <strong>{customer_name}</strong><br /><br />Saludos cordiales,<br />{company_name}',
    ],

    'appointment_remind_admin'   => [
        'subject' => 'Solicitud de cita recibida',
        'body'    => 'Hola,<br /><br />Solicitud de cita recibida.<br /><br />Detalles de la cita:<br /><br />Nombre de la cita: <strong>{appointment_name}</strong><br />Fecha de la cita: <strong>{appointment_date}</strong><br />Hora de la cita: <strong>{appointment_time}</strong><br />Nombre del cliente: <strong>{customer_name}</strong><br /><br />Saludos cordiales,<br />{company_name}',
    ],

    'appointment_remind_employee'   => [
        'subject' => 'Solicitud de cita recibida',
        'body'    => 'Hola,<br /><br />Solicitud de cita recibida.<br /><br />Detalles de la cita:<br /><br />Nombre de la cita: <strong>{appointment_name}</strong><br />Fecha de la cita: <strong>{appointment_date}</strong><br />Hora de la cita: <strong>{appointment_time}</strong><br />Nombre del cliente: <strong>{customer_name}</strong><br /><br />Saludos cordiales,<br />{company_name}',
    ],

];
