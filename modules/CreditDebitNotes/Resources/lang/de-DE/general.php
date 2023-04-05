<?php

return [

    'name'         => 'Gutschrift/Lieferschein',
    'description'  => 'Gut- oder Lieferschein erstellen',

    'credit_notes' => 'Gutschrift|Gutschriften',
    'debit_notes'  => 'Lieferschein|Lieferscheine',

    'vendors'      => 'Kreditor|Kreditoren',

    'empty' => [
        'credit_notes' => 'Gutschriften werden normalerweise verwendet, wenn ein Fehler in einer bereits ausgestellten Rechnung aufgetreten ist, eine falsche Menge, beschädigte Waren, oder wenn ein Kunde seine ursprüngliche Bestellung ändern möchte.',
        'debit_notes'  => 'In Lieferscheine wird der Inhalt jedes Pakets (Kiste, Paletten usw.) aufgeführt. Sie enthält Gewichte, Maße und detaillierte Listen der Waren in jedem Paket. Die Packliste sollte dem Karton oder dem Paket beigefügt werden und kann an der Außenseite des Pakets mit einer Kopie im Inneren angebracht werden.',
    ],

];
