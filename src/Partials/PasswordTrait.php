<?php

/**
 * This file is part of the Mirage Framework (https://miragedigitals.org/framework)
 * Copyright (c) 2024 Sina Kuhestani (https://kuhestani.org)
 */

declare(strict_types= 1);

namespace Mirage\Url\Partials;

trait PasswordTrait
{
    private ?string $password = NULL;

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function setPasswordSafe(?string $password): void
    {
        if (TRUE === empty($password)) $password = NULL;
        $this->password = $password;
    }
}