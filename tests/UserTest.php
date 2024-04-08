<?php declare(strict_types=1);
use Mirage\Url\Url;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testUser(): void
    {
        $users = ["mike", "sarah", "andrew", "john"];
        foreach ($users as $user)
        {
            $url = new Url("//" . urlencode($user) . ":password@sub.domain.tld/path/?q=query");
            $this->assertSame($user, $url->getUser());
        }

        $url = new Url("//user:password@sub.domain.tld/path/?q=query");

        $url->setUser("");
        $this->assertSame("", $url->getUser());

        $url->setUser(NULL);
        $this->assertSame(NULL, $url->getUser());

        $url->setUserSafe();
        $this->assertSame(NULL, $url->getUser());

        $url->setUserSafe("");
        $this->assertSame(NULL, $url->getUser());

    }
}
