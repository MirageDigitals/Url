<?php declare(strict_types=1);
use Mirage\Url\Url;
use PHPUnit\Framework\TestCase;

final class PasswordTest extends TestCase
{
    public function testPassword(): void
    {
        $passwords = ["xs7cXy", "cJ#5@q", "a?.458", "mM$$?"];
        foreach ($passwords as $password) {
            $url = new Url("//user:" . urlencode($password) ."@sub.domain.tld/path/?q=query");
            $this->assertSame($password, $url->getPassword());
        }

        $url = new Url("//user:password@sub.domain.tld/path/?q=query");
        
        $url->setPassword("");
        $this->assertSame("", $url->getPassword());

        $url->setPassword(NULL);
        $this->assertSame(NULL, $url->getPassword());

        $url->setPasswordSafe();
        $this->assertSame(NULL, $url->getPassword());

        $url->setPasswordSafe("");
        $this->assertSame(NULL, $url->getPassword());

    }
}