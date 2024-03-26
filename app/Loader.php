<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Forminator;

class Loader
{
    /**
     * Loader constructor.
     */
    public function __construct()
    {
        add_filter('forminator_fields', [$this, 'registerField']);
    }

    /**
     * @param array<mixed> $fields
     * @return array<mixed>
     */
    public function registerField(array $fields): array
    {
        return array_merge($fields, [
            new Field()
        ]);
    }
}
