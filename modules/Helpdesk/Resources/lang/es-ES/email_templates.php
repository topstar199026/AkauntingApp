<?php

return [

    'ticket_created' => [
        'subject'   => 'Nueva incidencia {ticket_name} creada',
        'body'      => 'Estimado@ {ticket_reporter},<br /><br />Has creado una nueva incidencia con el asunto: {ticket_subject}.<br /><br />Mensaje:<br />{ticket_message}<br /><br />Saludos,<br />{company_name}',
    ],

    'ticket_updated' => [
        'subject'   => 'El estado de la incidencia {ticket_name} ha cambiado a {ticket_status}',
        'body'      => 'Estimad@ {ticket_reporter},<br /><br />El estado de la incidencia<i>{ticket_name} {ticket_subject}</i> ha cambiado a <strong>{ticket_status}</strong>. Por favor, comprueba la incidencia actualizada.<br /><br />Saludos cordiales,<br />{company_name}',
    ],

    'reply_created' => [
        'subject'   => 'Nueva respuesta en la incidencia {ticket_name}',
        'body'      => 'Estimado usuari@,<br /><br />Hay una nueva respuesta de {reply_author} relacionada con la incidencia <i>{ticket_name} {ticket_subject}</i><br /><br />Mensaje:<br />{reply_message}<br /><br />Saludos cordiales,<br />{company_name}',
    ],

];
