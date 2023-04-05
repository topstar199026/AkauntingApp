<?php

return [

    'success' => [
        'added'             => ':type adicionado!',
        'updated'           => ':type atualizado!',
        'deleted'           => ':type excluído!',
        'duplicated'        => ':type duplicado!',
        'imported'          => ':type importado!',
        'enabled'           => ':type habilitado!',
        'disabled'          => ':type desativado!',
        'started'           => ':type iniciado!',
        'stopped'           => ':type parou!',
    ],

    'error' => [
        'over_payment'      => 'Erro: Pagamento não adicionado! O valor que você inseriu é maior que o total: :amount',
        'not_user_company'  => 'Erro: você não tem permissão para gerenciar esta empresa!',
        'customer'          => 'Erro: Usuário não criado! :name já utiliza esse endereço de email.',
        'no_file'           => 'Erro: Nenhum arquivo selecionado!',
        'last_category'     => 'Erro: Não foi possível excluir a última :type categoria!',
        'change_type'       => 'Erro: não é possível alterar o tipo porque tem :text relacionado!',
        'invalid_apikey'    => 'Erro: A chave de API inserida é inválida!',
        'import_column'     => 'Erro: :message Planilha: :sheet. Número da linha: :line.',
        'import_sheet'      => 'Erro: Nome da planilha inválido. Por favor, verifique o arquivo de exemplo.',
        'unknown'           => 'Erro desconhecido. Por favor, tente novamente mais tarde.',
    ],

    'warning' => [
        'deleted'           => 'Aviso: Você não têm permissão para excluir <b>:name</b>, porque possui o :text relacionado.',
        'disabled'          => 'Aviso: Você não tem permissão para desativar <b>:name</b>, porque tem :text relacionado.',
        'disable_code'      => 'Aviso: você não tem permissão para desativar ou alterar a moeda de <b>:name</b> porque possui :text relacionado.',
        'payment_cancel'    => 'Aviso: Você cancelou recentemente o método de pagamento :method!',
    ],

];
