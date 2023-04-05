<?php

return [

    'title'                    => 'E-posta Şablonları',

    'proposal_send_customer'    => [
        'subject' => 'Fiyat teklifi oluşturuldu',
        'body'    => 'Sayın {customer_name},' .
                     '<br /><br />' .
                     'Sizlere yeni bir fiyat teklifi hazırladık. ' .
                     '<br /><br />' .
                     'Aşağıdaki bağlantıdan portala ulaşarak fiyat teklifinin detaylarını inceleyebilirsiniz: ' .
                     '<br /><br />' .
                     '<a href="{proposal_portal_link}">{proposal_description}</a>.' .
                     '<br /><br />' .
                     'Eğer portal erişim bilgileriniz yoksa aşağıdaki linki kullanabilirsiniz: ' .
                     '<br /><br />' .
                     '<a href="{proposal_guest_link}">{proposal_description}</a>.' .
                     '<br /><br />' .
                     'Herhangi bir sorunuz olursa lütfen bize yazın.' .
                     '<br /><br />' .
                     'İyi çalışmalar dileriz,' .
                     '<br />' .
                     '{company_name}',
    ],

];
