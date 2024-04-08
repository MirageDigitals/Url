<?php declare(strict_types=1);
use Mirage\Url\Url;
use PHPUnit\Framework\TestCase;

final class FragmentTest extends TestCase
{
    public function testFragment(): void
    {
        $fragments = ["div", "heading"];
        foreach ($fragments as $fragment)
        {
            $url = new Url("//user:password@sub.domain.tld/path/?q=query#$fragment");
            $this->assertSame($fragment, $url->getFragment());
        }

        $url = new Url("//user:password@sub.domain.tld/path/?q=query#fragment");

        $url->setFragment("");
        $this->assertSame("", $url->getFragment());

        $url->setFragment(NULL);
        $this->assertSame(NULL, $url->getFragment());

        $url->setFragmentSafe();
        $this->assertSame(NULL, $url->getFragment());

        $url->setFragmentSafe("");
        $this->assertSame(NULL, $url->getFragment());

    }
}
