<?php

return [

    'name'                  => 'Helpdesk',
    'message'               => 'Gestiona las incidencias de tus clientes y manténlas actualizadas.',

    'empty' => [
        'tickets'           => 'Puedes crear incidencias para informar de errores, problemas o peticiones. Será asignada a un agente para poder resolverla lo antes possible',
    ],

    'tickets'               => 'Incidencia|Incidencias',

    'ticket' => [
        'id'                => 'Identificación',
        'name'              => 'Nombre',
        'subject'           => 'Asunto',
        'message'           => 'Mensaje',
        'category'          => 'Categoría',
        'reporter'          => 'Informador',
        'assignee'          => 'Asignado a',
        'status'            => 'Estado',
        'created'           => 'Creada',
        'updated'           => 'Actualizada',
        'related_to'        => 'Relacionado con',
        'not_related'       => 'No relacionado con ningún documento',
    ],

    '_category' => [ // Avoids conflict with 'category' or 'categories' in search-string.php
        'change_request'    => 'Petición de cambio',
        'incident'          => 'Incidencia',
        'problem'           => 'Problema',
        'feature_request'   => 'Petición de nueva funcionalidad',
    ],

    'statuses'              => 'Estado|Estados',

    'status' => [
        'open'              => 'Abierto',
        'pending'           => 'Pendiente',
        'on_hold'           => 'En espera',
        'solved'            => 'Solucionado',
        'closed'            => 'Cerrado',
        'spam'              => 'Spam',
    ],

    'replies'                 => 'Respuesta|Respuestas',

    'reply' => [
        'internal_note'     => 'Nota interna',
        'message'           => 'Mensaje',
        'new_reply'         => 'Nueva respuesta',
    ],

    'priorities'            => 'Prioridad|Prioridades',

    'priority' => [
        'urgent'            => 'Urgente',
        'high'              => 'Alta',
        'medium'            => 'Media',
        'low'               => 'Baja',
    ],

    'created_at'            => 'Fecha de creación',
    'updated_at'            => 'Última actualización',

    'reporters'             => 'Informador|Informadores',
    'assignees'             => 'Responsable|Responsables',

    'error' => [
        'email_error'       => 'El correo no se ha enviado. Por favor, revisa la configuración del correo.',
    ],

    'form_description' => [
        'create'            => 'Entra la descripción de la incidencia, la categoría y otros detalles para hacer el seguimiento.',
        'edit'              => 'Puedes editar la descripción de la incidencia, la categoría y otros detalles para actualizar su estado.',
        'show'              => 'Cuando se creó la incidencia y por quién.',
    ],


    'download'              => 'Descarga los ficheros asociados a esta incidencia',

    'details'               => 'Details',

];