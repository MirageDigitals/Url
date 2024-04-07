<?php declare(strict_types=1);
use Mirage\Url\Url;
use PHPUnit\Framework\TestCase;

final class PortTest extends TestCase
{
    public function testPort(): void
    {
        $ports = [80, 443];
        foreach ($ports as $port) {
            $url = new Url("//user:password@sub.domain.tld:$port/path/?q=query");
            $this->assertSame($port, $url->getPort());
        }

        $url = new Url("//user:password@sub.domain.tld:80/path/?q=query");
        
        $url->setPort(0);
        $this->assertSame(0, $url->getPort());

        $url->setPort(NULL);
        $this->assertSame(NULL, $url->getPort());

        $url->setPortSafe();
        $this->assertSame(NULL, $url->getPort());

        $url->setPortSafe(0);
        $this->assertSame(NULL, $url->getPort());

        $url = new Url("//user:password@sub.domain.tld/path/?q=query");
        $this->assertSame($url->getDefaultPort(), $url->getPort());

    }
}