<?php

return [

    'title'                    => 'E-Mail-Vorlagen',

    'proposal_send_customer'    => [
        'subject' => 'Neuer Vorschlag erstellt',
        'body'    => 'Guten Tag {customer_name},' .
                     '<br /><br />' .
                     'Wir haben den folgenden Vorschlag für Sie vorbereitet. ' .
                     '<br /><br />' .
                     'Sie können die Details des Vorschlags auf dem Portal über den folgenden Link einsehen: ' .
                     '<br /><br />' .
                     '<a href="{proposal_portal_link}">{proposal_description}</a>.' .
                     '<br /><br />' .
                     'Wenn Sie keinen Zugang zum Portal haben, verwenden Sie bitte den folgenden Link: ' .
                     '<br /><br />' .
                     '<a href="{proposal_guest_link}">{proposal_description}</a>.' .
                     '<br /><br />' .
                     'Für Fragen stehen wir Ihnen gerne zur Verfügung.' .
                     '<br /><br />' .
                     'Beste Grüße,' .
                     '<br />' .
                     '{company_name}',
    ],

];
