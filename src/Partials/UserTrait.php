<?php

/**
 * This file is part of the Mirage Framework (https://miragedigitals.org/framework)
 * Copyright (c) 2024 Sina Kuhestani (https://kuhestani.org)
 */

declare(strict_types= 1);

namespace Mirage\Url\Partials;

trait UserTrait
{
    private ?string $user = NULL;

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user = NULL): void
    {
        
        $this->user = $user;
        return $this;
    }

    public function setUserSafe(string $user = NULL): void
    {
        if (TRUE === empty($user)) $user = NULL;
        $this->setUser($user);
    }
}