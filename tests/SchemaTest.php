<?php declare(strict_types=1);
use Mirage\Url\Url;
use PHPUnit\Framework\TestCase;

final class SchemaTest extends TestCase
{
    public function testScheme(): void
    {
        $schema = ["https", "http"];
        foreach ($schema as $scheme)
        {
            $url = new Url("$scheme://user:password@sub.domain.tld/path/?q=query");
            $this->assertSame($scheme, $url->getScheme());
        }

        $url->setScheme("");
        $this->assertSame("", $url->getScheme());

        $url->setScheme(NULL);
        $this->assertSame(NULL, $url->getScheme());

        $url->setSchemeSafe();
        $this->assertSame(NULL, $url->getScheme());

        $url->setSchemeSafe("");
        $this->assertSame(NULL, $url->getScheme());

        $url = new Url("//user:password@sub.domain.tld/path/?q=query");
        $this->assertSame($url->getDefaultScheme(), $url->getScheme());
    }
}
