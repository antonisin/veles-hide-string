# Veles Hide (String security hide)

## Author 
Maxim Antonisin <br>
[maxim.antonisin@gmail.com](mailto:maxim.antonisin@gmail.com) <br>
[Linkedin](https://www.linkedin.com/in/mantonishin/)

## Description
This package is designed and implemented to work with text/strings to replace/hide sensitive information.

## Requirements
- PHP 7.2+

## Options
- `length` - Number of chars to be replaced.
- `offset` - Number of chars to skip before replace.
- `hideChar` - Special symbol used for replace.
  
## Use
### String (MaximAntonisin\Veles\Type\EmailType::class)

#### Options
No additional options for this string type format. This type is default.

#### Replace chars
```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\StringType;

$result = VelesHide::hide('exampleDomainName@example.com', [
    StringType::LENGTH_OPTION  => 4,
    StringType::OFFSET_OPTION  => 2,
]);
var_dump($result);

//string(29) "ex****eDomainName@example.com"
```

### Email (MaximAntonisin\Veles\Type\EmailType::class)
#### Options
- `domainLength` - Number of chars to be replaced in domain part.
- `domainOffset` - Number of chars to be skipped to replace in domain part.

#### Basic usage
```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\EmailType;

$result = VelesHide::hide('exampleDomainName@example.com', [
    EmailType::LENGTH_OPTION  => 4,
    EmailType::OFFSET_OPTION  => 2,
], 'email');
var_dump($result);

//string(29) "ex****eDomainName@example.com"
```

#### Replace in email name and domain parts
```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\EmailType;

$result = VelesHide::hide('exampleDomainName@example.com', [
    EmailType::DOMAIN_LENGTH_OPTION => 4,
    EmailType::DOMAIN_OFFSET_OPTION => 2,
], 'email');

var_dump($result);

//string(29) "e****leDomainName@ex****e.com"
```

#### Replace only in email domain part  
```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\EmailType;

$result = VelesHide::hide('exampleDomainName@example.com', [
    EmailType::LENGTH_OPTION        => 0,
    EmailType::DOMAIN_LENGTH_OPTION => 4,
    EmailType::DOMAIN_OFFSET_OPTION => 2,
], 'email');
var_dump($result);

//string(29) "exampleDomainName@ex****e.com"
```
### Url (MaximAntonisin\Veles\Type\UrlType::class)
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
use MaximAntonisin\Veles\Type\UrlType;

$result = VelesHide::hide('https://foo.example.com/path/to/something?queryParam=queryValue', [
    UrlType::LENGTH_OPTION  => 4,
    UrlType::OFFSET_OPTION  => 2,
], 'url');
var_dump($result);

//string(23) "https://fo****ample.com"
```

#### Replace in scheme
```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\UrlType;

$result = VelesHide::hide('https://foo.example.com/path/to/something?queryParam=queryValue', [
    UrlType::LENGTH_OPTION         => 0,
    UrlType::SCHEME_LENGTH_OPTION  => 2,
    UrlType::SCHEME_OFFSET_OPTION  => 2,
], 'url');
var_dump($result);

//string(23) "ht**s://foo.example.com"
```

#### Replace in path
```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\UrlType;

$result = VelesHide::hide('https://foo.example.com/path/to/something?queryParam=queryValue', [
    UrlType::LENGTH_OPTION       => 0,
    UrlType::PATH_LENGTH_OPTION  => 6,
    UrlType::PATH_OFFSET_OPTION  => 2,
], 'url');
var_dump($result);

//string(41) "https://foo.example.com/p******/something"
```

#### Replace in query
```php
use MaximAntonisin\Veles\VelesHide;
use MaximAntonisin\Veles\Type\UrlType;

$result = VelesHide::hide('https://foo.example.com/path/to/something?queryParam=queryValue', [
    UrlType::LENGTH_OPTION        => 0,
    UrlType::PATH_LENGTH_OPTION   => 0,
    UrlType::QUERY_LENGTH_OPTION  => 4,
    UrlType::QUERY_OFFSET_OPTION  => 2,
], 'url');
var_dump($result);

//string(63) "https://foo.example.com/path/to/something?qu****aram=queryValue"
```
