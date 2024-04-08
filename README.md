# Url

An abstraction of Url, simple to use.

## Create a Url object

Create a Url object from global:

```
    use Mirage\Url\Url;

    $url = Url::fromGlobals();

```
Create a Url object using stringUrl (a string in valid Url format):
```
    $url = new Url("https//user:password@sub.domain.tld/host/?q=query#fragment");
```
You can also create a raw Url object and set its parts later:
```
    $url = new Url();
    $url->setScheme("https");
    $url->setUsername("user");
    $url->setPassword("password");
    $url->setHost("sub.domain.tld");
    $url->setPath("/host/");
    $url->setQuery(["q" => "query"]);
    $url->setFragment("fragment");
```

## Get Url String
```
    $stringUrl = $url->getAbsoluteUrl();
```
you can also `echo $url`
```
    public function __toString(): string
    {
        return $this->getAbsoluteUrl();
    }
``` 
## Get Canonical Url address
```
    $canonicalStringUrl = $url->getCanonical();
```

## Get Url parts
```
$fragment    = $url->getFragment();
$host        = $url->getHost();
$password    = $url->getPassword();
$path        = $url->getPath();
$port        = $url->getPort();
$query       = $url->getQuery();
$scheme      = $url->getScheme();
$user        = $url->getUser();
$stringUrl   = $url->getAbsoluteUrl();
$authority   = $url->getAuthority();
$hostUrl     = $url->getHostUrl();
$domain      = $url->getDomain();
$basePath    = $url->getBasePath();
$baseUrl     = $url->getBaseUrl();
$relativeUrl = $url->getRelativeUrl();
```

## Compare Url object with a string Url
```
$bool = $url->isEqual($stringUrl);
```

## Overcome NULL and avoid ""
Just use safe methods `setSchemeSafe`, `setUsernameSafe`, `setPasswordSafe`, `setHostSafe`, `setPathSafe`, `setQuerySafe`, `setFragmentSafe`. See below
```
$url->setScheme("");        ==>   $url->getScheme = "";
$url->setScheme(NULL);      ==>   $url->getScheme = NULL;
$url->setSchemeSafe("");    ==>   $url->getScheme = NULL;
$url->setSchemeSafe(NULL);  ==>   $url->getScheme = NULL;
```

## License
MIT License - Copyright (c) 2024 Mirage Digitals

## Contributors

[Sina Kuhestani](https://github.com/SinaKuhestani)
[Mitra Mohajerani](https://github.com/mitramj)
[Farnaz Nic](https://github.com/farnaznic)