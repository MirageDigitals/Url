<?php

/**
 * This file is part of the Mirage Framework (https://miragedigitals.org/framework)
 * Copyright (c) 2024 Sina Kuhestani (https://kuhestani.org)
 */

declare(strict_types= 1);

namespace Mirage\Url\Partials;

trait PathTrait
{
    private ?string $path = NULL;

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path = NULL): void
    {
        $this->path = "/" . ltrim((string) $path, "/");
    }

    public function setPathSafe(?string $path): void
    {
        if (TRUE === empty($path)) $path = NULL;
        $this->setPath($path);
    }
}