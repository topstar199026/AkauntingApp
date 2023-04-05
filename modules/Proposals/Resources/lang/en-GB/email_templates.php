<?php

return [

    'title'                    => 'Email Templates',

    'proposal_send_customer'    => [
        'subject' => 'New proposal created',
        'body'    => 'Dear {customer_name},' .
                     '<br /><br />' .
                     'We have prepared the following proposal for you. ' .
                     '<br /><br />' .
                     'You could view the proposal details on portal from via below link: ' .
                     '<br /><br />' .
                     '<a href="{proposal_portal_link}">{proposal_description}</a>.' .
                     '<br /><br />' .
                     'If you do not have access to portal, please use below link: ' .
                     '<br /><br />' .
                     '<a href="{proposal_guest_link}">{proposal_description}</a>.' .
                     '<br /><br />' .
                     'Feel free to contact us for any question.' .
                     '<br /><br />' .
                     'Best Regards,' .
                     '<br />' .
                     '{company_name}',
    ],

];
