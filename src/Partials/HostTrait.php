<?php

/**
 * This file is part of the Mirage Framework (https://miragedigitals.org/framework)
 * Copyright (c) 2024 Sina Kuhestani (https://kuhestani.org)
 */

declare(strict_types=1);

namespace Mirage\Url\Partials;

trait HostTrait
{
    private ?string $host = NULL;

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setHost(?string $host = NULL): void
    {
        $this->host = $host;
    }

    public function setHostSafe(?string $host = NULL): void
    {
        if (TRUE === empty($host))
            $host = NULL;
        $this->setHost($host);
    }
}
