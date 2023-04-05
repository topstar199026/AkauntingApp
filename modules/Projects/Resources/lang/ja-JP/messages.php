<?php

return [

    'success' => [
        'added'             => ':type が追加されました！',
        'updated'           => ':type 更新しました！',
        'deleted'           => ':type 削除されました！',
        'duplicated'        => ':type 複製されました！',
        'imported'          => ':type インポートされました!',
        'enabled'           => ':type 有効になりました！',
        'disabled'          => ':type が無効です！',
    ],

    'error' => [
        'over_payment'      => 'Error: 支払いは追加されません！入力した金額が合計を超えています: :amount',
        'not_user_company'  => 'Error: この会社の管理は許可されていません。',
        'customer'          => 'Error: ユーザーが作成されていません！ :name は既にこのメールアドレスを使用しています。',
        'no_file'           => 'Error: ファイルが選択されていません！',
        'last_category'     => 'Error: 最後は削除できません :type category!',
        'change_type'       => 'Error: タイプがあるためタイプを変更できません :text related!',
        'invalid_apikey'    => 'Error: 入力されたAPIキーは無効です！',
        'import_column'     => 'Error: :メッセージ シート名: :sheet. Line number: :line.',
        'import_sheet'      => 'Error: シート名が無効です。サンプルファイルをご確認ください。',
        'unknown'           => '不明なエラー。後でもう一度やり直してください。',
    ],

    'warning' => [
        'deleted'           => 'Warning: 削除することはできません <b>:name</b> それは持っているので :text related.',
        'disabled'          => 'Warning: 無効にすることはできません <b>:name</b> それは持っているので :text related.',
        'disable_code'      => 'Warning: 通貨を無効にしたり変更したりすることはできません <b>:name</b> それは持っているので :text related.',
        'payment_cancel'    => 'Warning: 最近キャンセルした :method payment!',
    ],

];
