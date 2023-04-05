<?php

return [

    'ticket_created' => [
        'subject'   => 'New ticket {ticket_name} created',
        'body'      => 'Dear {ticket_reporter},<br /><br />You have created a new ticket with subject: {ticket_subject}.<br /><br />Message:<br />{ticket_message}<br /><br />Best Regards,<br />{company_name}',
    ],

    'ticket_updated' => [
        'subject'   => 'Ticket {ticket_name} status changed to {ticket_status}',
        'body'      => 'Dear {ticket_reporter},<br /><br />Status for ticket <i>{ticket_name} {ticket_subject}</i> changed to <strong>{ticket_status}</strong>. Please check the updated ticket.<br /><br />Best Regards,<br />{company_name}',
    ],

    'reply_created' => [
        'subject'   => 'New reply on ticket {ticket_name}',
        'body'      => 'Dear user,<br /><br />There is a new reply from {reply_author} related to the ticket <i>{ticket_name} {ticket_subject}</i><br /><br />Message:<br />{reply_message}<br /><br />Best Regards,<br />{company_name}',
    ],

];
