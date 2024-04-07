<?php declare(strict_types=1);
use Mirage\Url\Url;
use PHPUnit\Framework\TestCase;

final class HostTest extends TestCase
{
    public function testHost(): void
    {
        $hosts = ["example.com", "sub.example-new.org", "example.com.co"];
        foreach ($hosts as $host) {
            $url = new Url("//user:password@".$host."/path/?q=query");
            $this->assertSame($host, $url->getHost());
        }

        $url = new Url("//user:host@sub.domain.tld/host/?q=query");
        
        $url->setHost("");
        $this->assertSame("", $url->getHost());

        $url->setHost(NULL);
        $this->assertSame(NULL, $url->getHost());

        $url->setHostSafe();
        $this->assertSame(NULL, $url->getHost());
        
        $url->setHostSafe("");
        $this->assertSame(NULL, $url->getHost());

    }
}