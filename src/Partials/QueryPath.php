<?php

/**
 * This file is part of the Mirage Framework (https://miragedigitals.org/framework)
 * Copyright (c) 2024 Sina Kuhestani (https://kuhestani.org)
 */

declare(strict_types= 1);

namespace Mirage\Url\Partials;

use Mirage\Url\UrlUtils;

trait QueryTrait
{
    private ?array $query = NULL;

    public function getQuery(): ?string
    {
        return http_build_query($this->query, '', '&', PHP_QUERY_RFC3986);
    }

    public function setQuery(string|array|null $query): void
    {
        $this->query = is_array($query) ? $query : UrlUtils::parseQuery((string) $query);
    }

    public function appendQuery(string|array|null $query): void
    {
        $this->query = is_array($query)
            ? $query + $this->query
            : UrlUtils::parseQuery($this->getQuery() . '&' . (string) $query);
    }

    public function getQueryParameters(): array
    {
        if (TRUE === is_array($this->query)) return $this->query;
        return (array) $this->query;
    }

    public function getQueryParameter(string $name): mixed
    {
        return $this->query[$name] ?? NULL;
    }

    public function setQueryParameter(string $name, mixed $value): void
    {
        $this->query[$name] = $value;
    }
}