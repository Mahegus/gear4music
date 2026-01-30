<?php

interface InventoryInterface {
    public function getName(): string;
    public function getPrice(): float;
    public function isAvailable(): bool;
    public function getWeight(): int;
    public function getBoxVolume(): int;
    public function getDaysToDeliver(): int;
    public function getStockLevel(): int;
}
