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
        if (TRUE === is_array($query)) {
            $this->query = $query;
            return;
        }
        else {
            if (TRUE ===is_string($query)) {
                $query = UrlUtils::parseQuery((string) $query);
            }
            else {
                $query = [];
            }
            $this->query = $query;
        }
    }

    public function setQuerySafe(string|array|null $query = NULL): void
    {
        if (TRUE === is_array($query)) {
            $this->query = $query;
            return;
        }
        else {
            $query = UrlUtils::parseQuery((string) $query);
            $this->query = $query;
        }
    }

    public function appendQuery(string|array $query): void
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
        if (FALSE === empty($value)) {
            $this->query[$name] = $value;
        }
        else {
            if (TRUE === isset($this->query[$name])) unset ($this->query[$name]);
        }
    }

    public function removeQueryParameter(string $name)
    {
        $this->setQueryParameter($name, NULL);
    }
}