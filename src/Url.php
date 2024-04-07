<?php

/**
 * This file is part of the Mirage Framework (https://miragedigitals.org)
 * Copyright (c) 2024 Sina Kuhestani (https://kuhestani.org)
 */

declare(strict_types=1);

namespace Mirage\Url;

use Mirage\Url\Partials\SchemaTrait;
use Mirage\Url\Partials\UserTrait;
use Mirage\Url\Partials\PasswordTrait;
use Mirage\Url\Partials\HostTrait;
use Mirage\Url\Partials\PortTrait;
use Mirage\Url\Partials\PathTrait;
use Mirage\Url\Partials\QueryTrait;
use Mirage\Url\Partials\FragmentTrait;

use Mirage\Url\UrlUtils;

class Url implements \JsonSerializable
{
    use SchemaTrait, UserTrait, PasswordTrait, HostTrait, PortTrait, PathTrait, QueryTrait, FragmentTrait;

    public function __construct(?string $url = NULL)
    {
        $parsedUrl = @parse_url($url);
        if (FALSE === $parsedUrl)
        {
            throw new \exception("Malformed or unsupported URI '$url'.");
        }
        // print_r($parsedUrl);

        $this->setScheme($parsedUrl["scheme"] ?? $this->deafultScheme);
        $this->setPort((int) ($parsedUrl["port"] ?? $this->defaultPort));
        $this->setHost(rawurldecode((string) ($parsedUrl["host"] ?? NULL)));
        $this->setUser(rawurldecode((string) ($parsedUrl["user"] ?? NULL)));
        $this->setPassword(rawurldecode((string) ($parsedUrl["pass"] ?? NULL)));
        $this->setPath($parsedUrl["path"] ?? NULL);
        $this->setQuery($parsedUrl["query"] ?? []);
        $this->setFragment(rawurldecode((string) ($parsedUrl["fragment"] ?? NULL)));

    }
    final public function toArray(): array
    {
        return [
            "scheme" => $this->scheme, 
            "user" => $this->user, 
            "password" => $this->password, 
            "host" => $this->host, 
            "port" => $this->port, 
            "path" => $this->path, 
            "query" => $this->query, 
            "fragment" => $this->fragment
        ];
    }
    public function __toString(): string
    {
        return $this->getAbsoluteUrl();
    }
    public function jsonSerialize(): string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_SLASHES);
    }
    public function getAbsoluteUrl(): string
    {
        return $this->getHostUrl() . $this->path
            . (($tmp = $this->getQuery()) ? '?' . $tmp : '')
            . ($this->fragment === '' ? '' : '#' . $this->fragment);
    }
    public function getAuthority(): string
    {
        return $this->host === ''
            ? ''
            : ($this->user !== ''
                ? rawurlencode($this->user) . ($this->password === '' ? '' : ':' . rawurlencode($this->password)) . '@'
                : '')
            . $this->host
            . ($this->port && $this->port !== 80
                ? ':' . $this->port
                : '');
    }
    public function getHostUrl(): string
    {
        return ($this->scheme ? $this->scheme . ':' : '')
            . (($authority = $this->getAuthority()) !== '' ? '//' . $authority : '');
    }


    # ! New Features

    // public function getDomain(int $level = 2): string
    // {
    //     $parts = ip2long($this->host)
    //         ? [$this->host]
    //         : explode('.', $this->host);
    //     $parts = $level >= 0
    //         ? array_slice($parts, -$level)
    //         : array_slice($parts, 0, $level);
    //     return implode('.', $parts);
    // }
    // public function getBasePath(): string
    // {
    //     $pos = strrpos($this->path, '/');
    //     return $pos === FALSE ? '' : substr($this->path, 0, $pos + 1);
    // }
    // public function getBaseUrl(): string
    // {
    //     return $this->getHostUrl() . $this->getBasePath();
    // }
    // public function getRelativeUrl(): string
    // {
    //     return substr($this->getAbsoluteUrl(), strlen($this->getBaseUrl()));
    // }
    // public function isEqual(string $url): bool
    // {
    //     $url   = new self($url);
    //     $query = $url->query;
    //     ksort($query);
    //     $query2 = $this->query;
    //     ksort($query2);
    //     $host  = rtrim($url->host, '.');
    //     $host2 = rtrim($this->host, '.');
    //     return $url->scheme === $this->scheme
    //         && (! strcasecmp($host, $host2)
    //             || UrlUtils::idnHostToUnicode($host) === UrlUtils::idnHostToUnicode($host2))
    //         && $url->getPort() === $this->getPort()
    //         && $url->user === $this->user
    //         && $url->password === $this->password
    //         && UrlUtils::unescape($url->path, '%/') === UrlUtils::unescape($this->path, '%/')
    //         && $query === $query2
    //         && $url->fragment === $this->fragment;
    // }
    // public function getCanonical(): static
    // {
    //     $this->path = preg_replace_callback(
    //         '#[^!$&\'()*+,/:;=@%]+#',
    //         fn(array $m): string => rawurlencode($m[0]),
    //         UrlUtils::unescape($this->path, '%/'),
    //     );
    //     $this->host = rtrim($this->host, '.');
    //     $this->host = UrlUtils::idnHostToUnicode(strtolower($this->host));
    //     return $this;
    // }
}
