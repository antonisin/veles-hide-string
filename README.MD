# Veles Hide (String security hide)
![](https://img.shields.io/packagist/l/maximantonisin/veles-hide-string?style=for-the-badge)
![](https://img.shields.io/packagist/v/maximantonisin/veles-hide-string?style=for-the-badge)
## Author 
Maxim Antonisin <br>
[maxim.antonisin@gmail.com](mailto:maxim.antonisin@gmail.com) <br>
[Linkedin](https://www.linkedin.com/in/mantonishin/)

## Description
This package is designed and implemented to work with text/strings to replace/hide sensitive information.

## Requirements
![](https://img.shields.io/packagist/dependency-v/maximantonisin/veles-hide-string/symfony/twig-bridge?style=for-the-badge)
![](https://img.shields.io/packagist/dependency-v/maximantonisin/veles-hide-string/php?style=for-the-badge)
![](https://img.shields.io/badge/composer-required-orange?style=for-the-badge)

- PHP 7.2+

## Options
- `length` - Number of chars to be replaced.
- `offset` - Number of chars to skip before replace.
- `hideChar` - Special symbol used for replace.
  
## Use
### String (MaximAntonisin\Veles\Type\StringTypeInterface::class)

#### Options
No additional options for this string type format. This type is default.

#### Replace chars

```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\StringTypeInterface;

$result = VelesHide::hide('exampleDomainName@example.com', [
    StringTypeStringTypeInterface::OPTION_LENGTH  => 4,
    StringTypeInterface::OPTION_OFFSET  => 2,
]);
var_dump($result);

//string(29) "ex****eDomainName@example.com"
```

### Email (MaximAntonisin\Veles\Type\EmailTypeInterface::class)
#### Options
- `domainLength` - Number of chars to be replaced in domain part.
- `domainOffset` - Number of chars to be skipped to replace in domain part.

#### Basic usage

```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\EmailTypeInterface;

$result = VelesHide::hide('exampleDomainName@example.com', [
    EmailTypeInterface::OPTION_LENGTH  => 4,
    EmailTypeInterface::OPTION_OFFSET  => 2,
], 'email');
var_dump($result);

//string(29) "ex****eDomainName@example.com"
```

#### Replace in email name and domain parts

```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\EmailTypeInterface;

$result = VelesHide::hide('exampleDomainName@example.com', [
    EmailTypeEmailTypeInterface::OPTION_DOMAIN_LENGTH => 4,
    EmailTypeInterface::OPTION_DOMAIN_OFFSET => 2,
], 'email');

var_dump($result);

//string(29) "e****leDomainName@ex****e.com"
```

#### Replace only in email domain part

```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\EmailTypeInterface;

$result = VelesHide::hide('exampleDomainName@example.com', [
    EmailTypeInterface::OPTION_LENGTH        => 0,
    EmailTypeInterface::OPTION_DOMAIN_LENGTH => 4,
    EmailTypeInterface::OPTION_DOMAIN_OFFSET => 2,
], 'email');
var_dump($result);

//string(29) "exampleDomainName@ex****e.com"
```
### Url (MaximAntonisin\Veles\Type\UrlTypeInterface::class)
#### Options
- `schemeLength` - Number of chars to be replaced in scheme part.
- `schemeOffset` - Number of chars to be skipped on replace in scheme part.
- `queryLength` - Number of chars to be replaced in query part.
- `queryOffset` - Number of chars to be skipped on replace in query part.
- `pathLength` - Number of chars to be replaced in path part.
- `pathOffset` - Number of chars to be skipped on replace in path part.

#### Basic Usage

```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\UrlTypeInterface;

$result = VelesHide::hide('https://foo.example.com/path/to/something?queryParam=queryValue', [
    UrlTypeInterface::OPTION_LENGTH  => 4,
    UrlTypeInterface::OPTION_OFFSET  => 2,
], 'url');
var_dump($result);

//string(23) "https://fo****ample.com"
```

#### Replace in scheme

```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\UrlTypeInterface;

$result = VelesHide::hide('https://foo.example.com/path/to/something?queryParam=queryValue', [
    UrlTypeInterface::OPTION_LENGTH         => 0,
    UrlTypeInterface::OPTION_SCHEME_LENGTH  => 2,
    UrlTypeInterface::OPTION_SCHEME_OFFSET  => 2,
], 'url');
var_dump($result);

//string(23) "ht**s://foo.example.com"
```

#### Replace in path

```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\UrlTypeInterface;

$result = VelesHide::hide('https://foo.example.com/path/to/something?queryParam=queryValue', [
    UrlTypeInterface::OPTION_LENGTH       => 0,
    UrlTypeInterface::OPTION_PATH_LENGTH  => 6,
    UrlTypeInterface::OPTION_PATH_OFFSET  => 2,
], 'url');
var_dump($result);

//string(41) "https://foo.example.com/p******/something"
```

#### Replace in query

```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\UrlTypeInterface;

$result = VelesHide::hide('https://foo.example.com/path/to/something?queryParam=queryValue', [
    UrlTypeInterface::OPTION_LENGTH        => 0,
    UrlTypeInterface::OPTION_PATH_LENGTH   => 0,
    UrlTypeInterface::OPTION_QUERY_LENGTH  => 4,
    UrlTypeInterface::OPTION_QUERY_OFFSET  => 2,
], 'url');
var_dump($result);

//string(63) "https://foo.example.com/path/to/something?qu****aram=queryValue"
```

## Support
<a href="https://www.buymeacoffee.com/sleepwalker"> <img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" height="50" width="210" alt="sleepwalker" style="margin-right: 12px;" /></a>
<a href="https://ko-fi.com/maximuscode"> <img src="https://cdn.ko-fi.com/cdn/kofi3.png?v=3" height="50" width="210" alt="maximuscode" /></a>