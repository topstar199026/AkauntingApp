<?php

return [

    'ticket_created' => [
        'subject'   => 'Nou tiquet {ticket_name}',
        'body'      => 'Benvolgut/da {ticket_reporter},<br /><br />Has creat una nou tiquet amb el títol: {ticket_subject}.<br /><br />Missatge:<br />{ticket_message}<br /><br />Salutacions,<br />{company_name}',
    ],

    'ticket_updated' => [
        'subject'   => 'El tiquet {ticket_name} ha canviat l\'estat a {ticket_status}',
        'body'      => 'Benvolgut/da usuari/a,<br /><br />L\'estat del tiquet <i>{ticket_name} {ticket_subject}</i> ha cavniat a <strong>{ticket_status}</strong>. Si us plau, comprova\'n l\'actualització.<br /><br />Salutacions,<br />{company_name}',
    ],

    'reply_created' => [
        'subject'   => 'Nova resposta al tiquet {ticket_name}',
        'body'      => 'Benvolgut/da {ticket_reporter},<br /><br />Hi ha una nova resposta de {reply_author} relacionada amb el tiquet <i>{ticket_name} {ticket_subject}</i><br /><br />Missatge:<br />{reply_message}<br /><br />Salutacions,<br />{company_name}',
    ],

];
