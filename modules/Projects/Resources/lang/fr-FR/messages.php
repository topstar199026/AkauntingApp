<?php

return [

    'success' => [
        'added'             => ':type ajouté !',
        'updated'           => ':type mis à jour !',
        'deleted'           => ':type supprimé !',
        'duplicated'        => ':type dupliqué !',
        'imported'          => ':type importé !',
        'enabled'           => ':type activé !',
        'disabled'          => ':type désactivé !',
        'started'           => ':type a commencé!',
        'stopped'           => ':type arrêté!',
    ],

    'error' => [
        'over_payment'      => 'Erreur: Paiement non ajouté! Le montant que vous avez entré passe le total: :amount',
        'not_user_company'  => 'Erreur: Vous n\'êtes pas autorisé à gérer cette société !',
        'customer'          => 'Erreur: L\'utilisateur n\'a pas été créé! :name utilise déjà cette adresse e-mail.',
        'no_file'           => 'Erreur: Aucun fichier sélectionné!',
        'last_category'     => 'Erreur: Impossible de supprimer la dernière catégorie de type :type!',
        'change_type'       => 'Erreur: Impossible de changer le type car il est lié à :text!',
        'invalid_apikey'    => 'Erreur: La clé API saisie n\'est pas valide!',
        'import_column'     => 'Erreur: :message Nom de la feuille: :sheet. Numéro de ligne: :line.',
        'import_sheet'      => 'Erreur : Le nom de la feuille n\'est pas valide. Veuillez télécharger le modèle de fichier.',
        'unknown'           => 'Erreur inconnue. Veuillez réessayer ultérieurement.',
    ],

    'warning' => [
        'deleted'           => 'Avertissement: Vous n’êtes pas autorisé à supprimer <b>:name</b> parce qu’il est associé à :text.',
        'disabled'          => 'Avertissement: Vous n’êtes pas autorisé à désactiver <b>:name</b> parce qu’il est associé à :text.',
        'disable_code'      => 'Attention : vous n’êtes pas autorisé à désactiver ou modifier la monnaie de <b>:name</b> car elle a un lien avec :text.',
        'payment_cancel'    => 'Avertissement: Vous avez annulé votre paiement récent par :method!',
    ],

];
