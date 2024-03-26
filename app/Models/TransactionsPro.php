<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Forminator\Models;

use BeycanPress\CryptoPay\Models\AbstractTransaction;

class TransactionsPro extends AbstractTransaction
{
    public string $addon = 'forminator';

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct('forminator_transaction');
    }
}
