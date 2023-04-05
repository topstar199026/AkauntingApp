<?php

return [

    'ticket_created' => [
        'subject'   => 'Створено нову заяву {ticket_name}',
        'body'      => 'Шановний {ticket_reporter},<br /><br />Ви створили нову заяву із темою: {ticket_subject}.<br /><br />Повідомлення:<br />{ticket_message}<br /><br />З найкращими побажаннями, <br />{company_name}',
    ],

    'ticket_updated' => [
        'subject'   => 'Статус {ticket_name} заяви змінено на {ticket_status}',
        'body'      => 'Шановний {ticket_reporter},<br /><br />Статус заяви <i>{ticket_name} {ticket_subject}</i> змінено на <strong>{ticket_status}</strong>. Перевірте оновлену заяву.<br /><br />З найкращими побажаннями,<br />{company_name}',
    ],

    'reply_created' => [
        'subject'   => 'Нова відповідь на заяву {ticket_name}',
        'body'      => 'Шановний користувач,<br /><br />Є нова відповідь {reply_author}, яка пов\'язана із заявкою <i>{ticket_name} {ticket_subject}</i><br /><br />Повідомлення:<br />{reply_message}<br /><br />З найкращими побажаннями,<br />{company_name}',
    ],

];
