<?php

namespace App\DTO;

class InvoiceItemDTO
{
    public function __construct(
        public string $item,
        public float $unitPrice,
        public int $quantity,
    ) {
    }
}
