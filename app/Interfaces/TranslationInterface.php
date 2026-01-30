<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Enums\Language;

interface TranslationInterface
{
    public function getName(Language $language): string;

    public function getDescription(Language $language): string;
}