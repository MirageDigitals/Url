<?php declare(strict_types=1);
use Mirage\Url\Url;
use PHPUnit\Framework\TestCase;

final class FragmentTest extends TestCase
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
                $urlString = $urlString . rawurlencode($user);
                foreach ($passwords as $password) {
                    if (FALSE === empty($password)) $urlString = $urlString . ":" . rawurlencode($password);
                    foreach($hosts as $host) {
                        if (empty($user) && empty($password)) {
                            $urlString = $urlString . $host;
                        }
                        else {
                            $urlString = $urlString . "@" . $host;
                        }
                        foreach ($ports as $port) {
                            if (!empty($port)) $urlString = $urlString . ":" . $port;
                            foreach($paths as $path) {
                                $urlString = $urlString . $path;
                                foreach($querys as $query) {
                                    if (!empty($query)) $urlString = $urlString . "?" . $query;
                                    foreach($fragments as $fragment) {
                                        if (!empty($fragment)) $urlString = $urlString . "#" . $fragment;
                                        $url = new Url($urlString);
                                        $array = $url->toArray();
                                        $testArray = [
                                            "scheme" => $scheme, 
                                            "user" => $user, 
                                            "password" => $password, 
                                            "host" => $host, 
                                            "port" => $port, 
                                            "path" => $path, 
                                            "query" => $query, 
                                            "fragment" => $fragment
                                        ];
                                        $this->assertSame($array, $testArray);
                                        $string = $url->getAbsoluteUrl();
                                        $this->assertSame($string, $urlString);
                                        
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}