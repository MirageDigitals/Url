<?php

/**
 * This file is part of the Mirage Framework (https://miragedigitals.org/framework)
 * Copyright (c) 2024 Sina Kuhestani (https://kuhestani.org)
 */

declare(strict_types= 1);

namespace Mirage\Url\Partials;

trait FragmentTrait
{
    private ?string $fragment = NULL;

    public function getFragment(): ?string
    {
        return $this->fragment;
    }
    
    public function setFragment(?string $fragment): void
    {
        $this->fragment = $fragment;
    }

    public function setFragmentSafe(?string $fragment = NULL): void
    {
        if (TRUE === empty($fragment)) $fragment = NULL;
        $this->setFragment($fragment);
    }
}