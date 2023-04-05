<?php

// composer autoloader
require dirname(__DIR__) . 'vendor/autoload.php';

// instantiate the actual parser
// and parse them from a given file, this could be any file or a posted string
$parser = new \Kingsquare\Parser\Banking\Mt940();
$tmpFile = __DIR__ . '/test.mta';
foreach ($parser->parse(file_get_contents($tmpFile)) as $key => $statement) {
    $transactions = $statement->getTransactions();
    // handle the transactions
    foreach ($transactions as $transaction) {
        // do something per transaction $transaction->getDescription();
        // etc
    }
}