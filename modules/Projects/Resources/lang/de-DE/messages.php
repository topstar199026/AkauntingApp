<?php

return [

    'success' => [
        'added'             => ':type hinzugefügt!',
        'updated'           => ':type aktualisiert!',
        'deleted'           => ':type gelöscht!',
        'duplicated'        => ':type dupliziert!',
        'imported'          => ':type importiert!',
        'enabled'           => ':type aktiviert!',
        'disabled'          => ':type deaktiviert!',
        'started'           => ':type gestartet!',
        'stopped'           => ':type beendet!',
    ],

    'error' => [
        'over_payment'      => 'Fehler: Zahlung wurde nicht gebucht! Der eingegebenen Betrag überschreitet die Gesamtsumme von: :amount',
        'not_user_company'  => 'Fehler: Sie haben keine Berechtigung, die Firmendaten zu ändern!',
        'customer'          => 'Fehler: Benutzer nicht erstellt! Der Benutzer :name verwendet bereits diese E-Mail-Adresse.',
        'no_file'           => 'Fehler: Keine Datei ausgewählt!',
        'last_category'     => 'Fehler: Kann die letzte Kategorie :type nicht löschen!',
        'change_type'       => 'Fehler: Der Typ kann nicht geändert werden, da :text verwandt ist!',
        'invalid_apikey'    => 'Fehler: Der eingegebene API-Schlüssel ist ungültig!',
        'import_column'     => 'Fehler: :message. Name des Blattes: :sheet. Zeilennummer: :line.',
        'import_sheet'      => 'Fehler: Name des Blattes ist nicht gültig. Bitte die Beispieldatei überprüfen.',
        'unknown'           => 'Unbekannter Fehler. Bitte versuchen Sie es später erneut.',
    ],

    'warning' => [
        'deleted'           => 'Warnung: Sie dürfen <b>:name</b> nicht löschen, da :text dazu in Bezug steht.',
        'disabled'          => 'Warnung: Sie dürfen <b>:name</b> nicht deaktivieren, da :text dazu in Bezug steht.',
        'disable_code'      => 'Warnung: Sie dürfen die Währung von <b>:name</b> nicht deaktivieren oder verändern, da :text dazu in Bezug steht.',
        'payment_cancel'    => 'Warnung: Sie haben Ihre letzte Zahlung :method abgebrochen!',
    ],

];
