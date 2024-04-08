<?php

/**
 * This file is part of the Mirage Framework (https://miragedigitals.org/framework)
 * Copyright (c) 2024 Sina Kuhestani (https://kuhestani.org)
 */

declare(strict_types=1);

namespace Mirage\Url\Partials;

trait PortTrait
{
    private ?int $port = NULL;

    private int $defaultPort = 80;

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(?int $port = NULL): void
    {
        $this->port = $port;
    }

    public function setPortSafe(?int $port = NULL): void
    {
        if (TRUE === empty($port))
            $port = NULL;
        $this->setPort($port);
    }

    public function getDefaultPort(): int
    {
        return $this->defaultPort;
    }
}
