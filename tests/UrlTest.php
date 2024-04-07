<?php declare(strict_types=1);
use Mirage\Url\Url;
use PHPUnit\Framework\TestCase;

final class UrlTest extends TestCase
{
    public function testUrl(): void
    {
        $schema = ["http", "https", ""];
        $users = ["mike", "sarah", "andrew", ""];
        $passwords = ["xs7cXy", "cJ#5@q", "a?.458", ""];
        $hosts = ["example.com", "sub.example-new.org", "example.com.co"];
        $paths = ["/dir/file.ext", "/", "/dir/subdir/"];
        $ports = [80,443,0];
        $querys = ["q=query", "q1=query1&q2=query2", ""];
        $fragments = ["div", "heading"];
        foreach ($schema as $scheme) {
            $urlString = $scheme;
            if (FALSE === empty($scheme)) $urlString = $urlString . ":";
            $urlString = $urlString . "//";
            foreach ($users as $user) {
                $cacheUser = $urlString;
                $urlString = $urlString . rawurlencode($user);
                foreach ($passwords as $password) {
                    $cachePassword = $urlString;
                    if (FALSE === empty($password) && FALSE === empty($user)) $urlString = $urlString . ":" . rawurlencode($password);
                    foreach($hosts as $host) {
                        $cacheHost = $urlString;
                        if (!empty($user)) {
                            $urlString = $urlString . "@" . $host;
                        }
                        else {
                            $urlString = $urlString . $host;
                        }
                        foreach ($ports as $port) {
                            $cachePort = $urlString;
                            if (!empty($port)) $urlString = $urlString . ":" . $port;
                            foreach($paths as $path) {
                                $cachePath = $urlString;
                                $urlString = $urlString . $path;
                                foreach($querys as $query) {
                                    $cacheQuery = $urlString;
                                    if (!empty($query)) $urlString = $urlString . "?" . $query;
                                    foreach($fragments as $fragment) {
                                        $cacheFragment = $urlString;
                                        if (!empty($fragment)) $urlString = $urlString . "#" . $fragment;
                                        $url = new Url($urlString);
                                        $array = $url->toArray();
                                        parse_str($query, $queryArray);
                                        $testArray = [
                                            "scheme" => !empty($scheme) ? $scheme : "https", 
                                            "user" => $user, 
                                            "password" => !empty($user) && !empty($password) ? $password : "", 
                                            "host" => $host, 
                                            "port" => !empty($port) ? $port : 80, 
                                            "path" => $path, 
                                            "query" => $queryArray, 
                                            "fragment" => $fragment
                                        ];
                                        $this->assertSame($array, $testArray);
                                        $string = $url->getAbsoluteUrl();
                                        $testString = $urlString;
                                        if (80 === $port) {
                                            $testString = str_replace(":80","",$urlString);
                                        }
                                        if (empty($scheme)) $testString = "https:" . $testString;
                                        $this->assertSame($string, $testString);
                                        $urlString = $cacheFragment;
                                        unset($cache);
                                    }
                                    $urlString = $cacheQuery;
                                    unset($cacheQuery);
                                }
                                $urlString = $cachePath;
                                unset($cachePath);
                            }
                            $urlString = $cachePort;
                            unset($cachePort);
                        }
                        $urlString = $cacheHost;
                        unset($cacheHost);
                    }
                    $urlString = $cachePassword;
                    unset($cachePassword);
                }
                $urlString = $cacheUser;
                unset($cacheUser);
            }
            $urlString = "";
        }
        $url = new Url("https://sub.domain.tld/path/?q=query#fragment");
        $canonicalUrlString = "https://sub.domain.tld/path/?q=query";
        $this->assertSame($canonicalUrlString, $url->getCanonical());

        $url = new Url("https://sub.domain.tld/path/?q=query#fragment");
        $basrPathString = "/path/";
        $this->assertSame($basrPathString, $url->getBasePath());

        $url = new Url("https://sub.domain.tld/path/?q=query#fragment");
        $basrString = "https://sub.domain.tld/path/";
        $this->assertSame($basrString, $url->getBaseUrl());

        $url = new Url("https://sub.domain.tld/path/?q=query#fragment");
        $relativeUrlString = "?q=query#fragment";
        $this->assertSame($relativeUrlString, $url->getRelativeUrl());

        $url = new Url("https://sub.domain.tld/path/?q=query#fragment");
        $this->assertSame(TRUE, $url->isEqual("https://sub.domain.tld/path/?q=query#fragment"));

        $url = new Url("https://sub.domain.tld/path/?q=query#fragment");
        $this->assertSame("domain.tld", $url->getDomain());

        $url = new Url("https://sub.domain.tld.top/path/?q=query#fragment");
        $this->assertSame("domain.tld.top", $url->getDomain(3));
    }



}