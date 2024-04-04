<?php

/**
 * This file is part of the Mirage Framework (https://miragedigitals.org/framework)
 * Copyright (c) 2024 Sina Kuhestani (https://kuhestani.org)
 */

declare(strict_types= 1);

namespace Mirage\Url\Partials;

trait SchemaTrait
{
    private ?string $scheme = NULL;

    private string $deafultScheme = "https";

    public function getScheme(): ?string
    {
        return $this->scheme;
    }

    public function setScheme(?string $scheme = NULL): void
    {
        $this->scheme = $scheme;
    }

    public function setSchemeSafe(?string $scheme = NULL): void
    {
        if (TRUE === empty($scheme)) $scheme = NULL;
        $this->setScheme($scheme);
    }

    public function getDefaultScheme(): string
    {
        return $this->deafultScheme;
    }
}