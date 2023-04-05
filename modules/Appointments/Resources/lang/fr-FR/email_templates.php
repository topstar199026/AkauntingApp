<?php

return [

    'title' => 'Modèles d\'e-mail',

    'appointment_new_request_customer' => [
        'subject'   => 'Nouveau client',
        'body'      => 'Votre demande de rendez-vous a été reçue<br /><br />Merci d\'avoir demandé un rendez-vous.<br /><br />Le résultat de votre demande de rendez-vous vous sera notifié par e-mail.<br /><br />N\'hésitez pas à nous contacter pour toute question.<br /><br />Cordialement,<br />{company_name}',
    ],

    'appointment_paid_request_customer' => [
        'subject'   => 'Frais de rendez-vous',
        'body'      => 'Cher/Chère {customer_name},<br /><br />Votre demande de rendez-vous a été approuvée<br /><br /><br /><br />Vous pouvez voir les détails du paiement à partir du lien suivant : <a href= "{invoice_guest_link}">{invoice_number}</a>.<br /><br />Cordialement,<br />{company_name}',
    ],

    'appointment_detail_customer' => [
        'subject'   => 'Détails du rendez-vous',
        'body'      => 'Cher {customer_name},<br /><br />Le processus de rendez-vous a été complété avec succès.<br /><br />Les détails de votre rendez-vous :<br /><br />Nom du rendez-vous : <strong>{appointment_name} </strong><br />Date du rendez-vous : <strong>{appointment_date}</strong><br />Heure du rendez-vous : <strong>{appointment_time}</strong><br />Durée du rendez-vous : <strong>{appointment_duration }</strong><br /><br />N\'hésitez pas à nous contacter pour toute question.<br /><br />Cordialement,<br />{company_name}',
    ],

    'appointment_remind_customer'  => [
        'subject'   => 'Rappel de rendez-vous',
        'body'      => 'Cher/Chère {customer_name},<br /><br />Le processus de rendez-vous a été complété avec succès.<br /><br />Les détails de votre rendez-vous :<br /><br />Nom du rendez-vous : <strong>{appointment_name} </strong><br />Date du rendez-vous : <strong>{appointment_date}</strong><br />Heure du rendez-vous : <strong>{appointment_time}</strong><br />Durée du rendez-vous : <strong>{appointment_duration }</strong><br /><br />N\'hésitez pas à nous contacter pour toute question.<br /><br />Cordialement,<br />{company_name}',
    ],

    'appointment_new_request_admin'   => [
        'subject'   => 'Demande de rendez-vous reçue',
        'body'      => 'Bonjour,<br /><br />Demande de rendez-vous reçue.<br /><br />Vos coordonnées de rendez-vous :<br /><br />Nom du rendez-vous : <strong>{appointment_name}</strong><br />Date du rendez-vous : <strong>{appointment_date}</strong><br />Heure du rendez-vous : <strong>{appointment_time}</strong><br />Nom du client : <strong>{customer_name}</strong><br /><br />Cordialement,<br />{company_name}',
    ],

    'appointment_remind_admin'   => [
        'subject'   => 'Demande de rendez-vous reçue',
        'body'      => 'Bonjour,<br /><br />Votre heure de rendez-vous approche.<br /><br />Vos coordonnées de rendez-vous :<br /><br />Nom du rendez-vous : <strong>{appointment_name}</strong><br />Date du rendez-vous : <strong>{appointment_date}</strong><br />Heure du rendez-vous : <strong>{appointment_time}</strong><br />Nom du client : <strong>{customer_name}</strong><br /><br />Cordialement,<br />{company_name}',
    ],

    'appointment_remind_employee'   => [
        'subject'   => 'Demande de rendez-vous reçue',
        'body'      => 'Bonjour,<br /><br />Votre heure de rendez-vous approche.<br /><br />Vos coordonnées de rendez-vous :<br /><br />Nom du rendez-vous : <strong>{appointment_name}</strong><br />Date du rendez-vous : <strong>{appointment_date}</strong><br />Heure du rendez-vous : <strong>{appointment_time}</strong><br />Nom du client : <strong>{customer_name}</strong><br /><br />Cordialement,<br />{company_name}',
    ],

];
