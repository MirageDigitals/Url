<?php

/**
 * This file is part of the Mirage Framework (https://miragedigitals.org)
 * Copyright (c) 2024 Sina Kuhestani (https://kuhestani.org)
 */

declare(strict_types=1);

namespace Mirage\Url;

class UrlUtils
{

    public static function idnHostToUnicode(string $host): ?string
    {
        if (! str_contains($host, '--'))
        {
            return $host;
        }

        if (function_exists('idn_to_utf8') && defined('INTL_IDNA_VARIANT_UTS46'))
        {
            return idn_to_utf8($host, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46) ?: $host;
        }

        trigger_error('PHP extension intl is not loaded or is too old', E_USER_WARNING);
        return NULL;
    }


    public static function unescape(string $s, string $reserved = '%;/?:@&=+$,'): string
    {
        if ($reserved !== '')
        {
            $s = preg_replace_callback(
                '#%(' . substr(chunk_split(bin2hex($reserved), 2, '|'), 0, -1) . ')#i',
                fn(array $m): string => '%25' . strtoupper($m[1]),
                $s,
            );
        }

        return rawurldecode($s);
    }

    public static function parseQuery(string $s): array
    {
        $s   = str_replace(['%5B', '%5b'], '[', $s);
        $sep = preg_quote(ini_get('arg_separator.input'));
        $s   = preg_replace("#([$sep])([^[$sep=]+)([^$sep]*)#", '&0[$2]$3', '&' . $s);
        parse_str($s, $res);
        return $res[0] ?? [];
    }
}