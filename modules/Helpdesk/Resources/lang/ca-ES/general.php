<?php

return [

    'name'                  => 'Helpdesk',
    'message'               => 'Gestiona els tiquets dels clients i manten-los actualitzats.',

    'empty' => [
        'tickets'           => 'Pots crear tiquets per informar d\'incidències, problemes o peticions. S\'assignarà a un agent per tal de resoldre-ho el més aviat possible',
    ],

    'tickets'               => 'Tiquet|Tiquets',

    'ticket' => [
        'id'                => 'ID',
        'name'              => 'Nom',
        'subject'           => 'Títol',
        'message'           => 'Missatge',
        'category'          => 'Categoria',
        'reporter'          => 'Informador',
        'assignee'          => 'Responsable',
        'status'            => 'Estat',
        'created'           => 'Creat',
        'updated'           => 'Actualitzat',
        'related_to'        => 'Relacionat amb',
        'not_related'       => 'No relacionat amb cap document',
    ],

    '_category' => [ // Avoids conflict with 'category' or 'categories' in search-string.php
        'change_request'    => 'Petició de canvi',
        'incident'          => 'Incidència',
        'problem'           => 'Problema',
        'feature_request'   => 'Petició de nova funcionalitat',
    ],

    'statuses'              => 'Estat|Estats',

    'status' => [
        'open'              => 'Nou',
        'pending'           => 'Pendent',
        'on_hold'           => 'En espera',
        'solved'            => 'Solucionat',
        'closed'            => 'Tancat',
        'spam'              => 'Spam',
    ],

    'replies'                 => 'Resposta|Respostes',

    'reply' => [
        'internal_note'     => 'Nota interna',
        'message'           => 'Missatge',
        'new_reply'         => 'Nova resposta',
    ],

    'priorities'            => 'Prioritat|Prioritats',

    'priority' => [
        'urgent'            => 'Urgent',
        'high'              => 'Alta',
        'medium'            => 'Mitjana',
        'low'               => 'Baixa',
    ],

    'created_at'            => 'Data de creació',
    'updated_at'            => 'Última actualització',

    'reporters'             => 'Informador|Informadors',
    'assignees'             => 'Responsable|Responsables',

    'error' => [
        'email_error'       => 'El correu no s\'ha enviat. Si us plau, revisa la configuració del correu.',
    ],

    'form_description' => [
        'create'            => 'Entra la descripció del problema, la categoria i altres detalls per tal de fer-ne el seguiment.',
        'edit'              => 'Pots editar la descripció del problema, la categoria i altres detalls per tal d\'actualitzar-ne l\'estat',
        'show'              => 'Data i persona que va crear el tiquet.',
    ],

    'download'              => 'Descarrega els arxius enllaçats a aquest tiquet',

    'details'               => 'Detalls',

];