<?php

return [

    'title'                    => 'Modèles d\'e-mail',

    'proposal_send_customer'    => [
        'subject' => 'Nouvelle proposition créée',
        'body'    => 'Cher {customer_name},' .
                     '<br /><br />' .
                     'Nous vous avons préparé la proposition suivante. ' .
                     '<br /><br />' .
                     'Vous pouvez voir les détails de la proposition sur le portail à partir du lien ci-dessous : ' .
                     '<br /><br />' .
                     '<a href="{proposal_portal_link}">{proposal_description}</a>.' .
                     '<br /><br />' .
                     'Si vous n\'avez pas accès au portail, veuillez utiliser le lien ci-dessous : ' .
                     '<br /><br />' .
                     '<a href="{proposal_guest_link}">{proposal_description}</a>.' .
                     '<br /><br />' .
                     'N\'hésitez pas à nous contacter pour toute question.' .
                     '<br /><br />' .
                     'Bien cordialement,' .
                     '<br />' .
                     '{company_name}',
    ],

];
