<?php

return [

    'title'                    => 'قالب های ایمیل',

    'proposal_send_customer'    => [
        'subject' => 'طرح پیشنهادی جدید ساخته شد',
        'body'    => '{customer_name} عزیز,' .
                     '<br /><br />' .
                     'ما پیشنهاد زیر را برای شما آماده کرده ایم. ' .
                     '<br /><br />' .
                     'جزئیات پیشنهاد را می توانید از طریق لینک زیر در پورتال مشاهده کنید: ' .
                     '<br /><br />' .
                     '<a href="{proposal_portal_link}">{proposal_description}</a>.' .
                     '<br /><br />' .
                     'اگر به پورتال دسترسی ندارید ، لطفا از لینک زیر استفاده کنید: ' .
                     '<br /><br />' .
                     '<a href="{proposal_guest_link}">{proposal_description}</a>.' .
                     '<br /><br />' .
                     'برای هر گونه سوال با ما تماس بگیرید.' .
                     '<br /><br />' .
                     'با احترام،' .
                     '<br />' .
                     '{company_name}',
    ],

];
