<?php declare(strict_types=1);
use Mirage\Url\Url;
use PHPUnit\Framework\TestCase;

final class PathTest extends TestCase
{
    public function testPath(): void
    {
        $paths = ["/dir/file.ext", "/", "/dir/subdir/"];
        foreach ($paths as $path)
        {
            $url = new Url("//user:password@sub.domain.tld" . $path . "?v=" . (string) time());
            $this->assertSame($path, $url->getPath());
        }

        $url = new Url("//user:path@sub.domain.tld/path/?q=query");

        $url->setPath("");
        $this->assertSame("/", $url->getPath());

        $url->setPath(NULL);
        $this->assertSame("/", $url->getPath());

        $url->setPathSafe();
        $this->assertSame("/", $url->getPath());

        $url->setPathSafe("");
        $this->assertSame("/", $url->getPath());

    }
}
