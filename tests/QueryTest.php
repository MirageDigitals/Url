<?php declare(strict_types=1);
use Mirage\Url\Url;
use PHPUnit\Framework\TestCase;

final class QueryTest extends TestCase
{
    public function testQuery(): void
    {
        $querys = ["q=query", "q1=query1&q2=query2", ""];
        foreach ($querys as $query)
        {
            $url = new Url("//user:password@sub.domain.tld/path/?$query");
            $this->assertSame($query, $url->getQuery());
        }

        $url = new Url("//user:query@sub.domain.tld/query/?q=query");

        $url->setQuery("");
        $this->assertSame("", $url->getQuery());

        $url->setQuery(NULL);
        $this->assertSame("", $url->getQuery());

        $url->setQuerySafe();
        $this->assertSame("", $url->getQuery());

        $url->setQuerySafe("");
        $this->assertSame("", $url->getQuery());

        $url->appendQuery(["q" => "query"]);
        $this->assertSame("q=query", $url->getQuery());

        $url->appendQuery("q2=query2");
        $this->assertSame("q=query&q2=query2", $url->getQuery());

        $params = $url->getQueryParameters();
        $this->assertSame(["q" => "query", "q2" => "query2"], $params);

        $param = $url->getQueryParameter("q2");
        $this->assertSame("query2", $param);

        $param = $url->getQueryParameter("q3");
        $this->assertSame(NULL, $param);

        $url->setQueryParameter("q3", "query3");
        $this->assertSame(["q" => "query", "q2" => "query2", "q3" => "query3"], $url->getQueryParameters());

        $url->setQueryParameter("q3", NULL);
        $this->assertSame(["q" => "query", "q2" => "query2"], $url->getQueryParameters());

        $url->removeQueryParameter("q2");
        $this->assertSame(["q" => "query"], $url->getQueryParameters());
    }
}
