<?php

return [

    'success' => [
        'added'                     => ':type added!',
        'updated'                   => ':type updated!',
        'deleted'                   => ':type deleted!',
        'duplicated'                => ':type duplicated!',
        'imported'                  => ':type imported!',
        'enabled'                   => ':type enabled!',
        'disabled'                  => ':type disabled!',
        'started'                   => ':type started!',
        'stopped'                   => ':type stopped!',
    ],

    'error' => [
        'over_payment'              => 'Error: Payment not added! The amount you entered passes the total: :amount',
        'not_user_company'          => 'Error: You are not allowed to manage this company!',
        'customer'                  => 'Error: User not created! :name already uses this email address.',
        'no_file'                   => 'Error: No file selected!',
        'last_category'             => 'Error: Can not delete the last :type category!',
        'change_type'               => 'Error: Can not change the type because it has :text related!',
        'invalid_apikey'            => 'Error: The API Key entered is invalid!',
        'import_column'             => 'Error: :message Sheet name: :sheet. Line number: :line.',
        'import_sheet'              => 'Error: Sheet name is not valid. Please, check the sample file.',
        'unknown'                   => 'Unknown error. Please, try again later.',
        'timesheet_for_invoice'     => 'The task does not have any Timesheet.',
        'prevent_user_delete'       => 'You can\'t delete this user because it has projects and the project also contains tasks and comments associated with the user.',
    ],

    'warning' => [
        'deleted'                   => 'Warning: You are not allowed to delete <b>:name</b> because it has :text related.',
        'disabled'                  => 'Warning: You are not allowed to disable <b>:name</b> because it has :text related.',
        'disable_code'              => 'Warning: You are not allowed to disable or change the currency of <b>:name</b> because it has :text related.',
        'payment_cancel'            => 'Warning: You have cancelled your recent :method payment!',
    ],

];
