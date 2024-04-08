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


    public static function unescape(string $string, string $reservedChars = '%;/?:@&=+$,'): string
    {
        if ($reservedChars !== '')
        {
            $string = preg_replace_callback(
                '#%(' . substr(chunk_split(bin2hex($reservedChars), 2, '|'), 0, -1) . ')#i',
                fn(array $temp): string => '%25' . strtoupper($temp[1]),
                $string,
            );
        }

        return rawurldecode($string);
    }

    public static function parseQuery(string $string): array
    {
        $string    = str_replace(['%5B', '%5b'], '[', $string);
        $separator = preg_quote(ini_get('arg_separator.input'));
        $string    = preg_replace("#([$separator])([^[$separator=]+)([^$separator]*)#", '&0[$2]$3', '&' . $string);
        parse_str($string, $res);
        return $res[0] ?? [];
    }
}
