<?php

return [

    'name'                  => 'Helpdesk',
    'message'               => 'Manage tickets from your customers and keep them updated.',

    'empty' => [
        'tickets'           => 'You can create tickets to report an incident, problem or a request. It will be assigned to an agent so it can be attended as soon as possible',
    ],

    'tickets'               => 'Ticket|Tickets',

    'ticket' => [
        'id'                => 'ID',
        'name'              => 'Name',
        'subject'           => 'Subject',
        'message'           => 'Message',
        'category'          => 'Category',
        'reporter'          => 'Reporter',
        'assignee'          => 'Assignee',
        'status'            => 'Status',
        'created'           => 'Created',
        'updated'           => 'Updated',
        'related_to'        => 'Related to',
        'not_related'       => 'Not related to any document',
    ],

    '_category' => [ // Avoids conflict with 'category' or 'categories' in search-string.php
        'change_request'    => 'Change request',
        'incident'          => 'Incident',
        'problem'           => 'Problem',
        'feature_request'   => 'New feature request',
    ],

    'statuses'              => 'Status|Statuses',

    'status' => [
        'open'              => 'Open',
        'pending'           => 'Pending',
        'on_hold'           => 'On hold',
        'solved'            => 'Solved',
        'closed'            => 'Closed',
        'spam'              => 'Spam',
    ],

    'replies'                 => 'Reply|Replies',

    'reply' => [
        'internal_note'     => 'Internal note',
        'message'           => 'Message',
        'new_reply'         => 'New Reply',
    ],

    'priorities'            => 'Priority|Priorities',

    'priority' => [
        'urgent'            => 'Urgent',
        'high'              => 'High',
        'medium'            => 'Medium',
        'low'               => 'Low',
    ],

    'created_at'            => 'Creation date',
    'updated_at'            => 'Last update',

    'reporters'             => 'Reporter|Reporters',
    'assignees'             => 'Assignee|Assignees',

    'error' => [
        'email_error'       => 'Email not sent. Please review email Settings',
    ],

    'form_description' => [
        'create'            => 'Enter the ticket subject, category and other details in order to track the issue.',
        'edit'              => 'You can edit the ticket subject, category and other details in order to update the issue.',
        'show'              => 'When the ticket was created and who created it.',
    ],

    'download'              => 'Download the files attached to this ticket',

    'details'               => 'Details',

];