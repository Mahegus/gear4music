<?php

class ProductIndexer
{
    public function getInventory() {
        return $this->fetchInventory();
    }

    private function fetchInventory(): array {
        // Imagine database operations here
        return [
            new SimpleInventory(),
            new SimpleInventory(),
            new SimpleInventory(),
        ];
    }
}