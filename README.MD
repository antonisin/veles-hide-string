# Veles Hide (String security hide)

## Author 
Maxim Antonisin <br>
[maxim.antonisin@gmail.com](mailto:maxim.antonisin@gmail.com) <br>
[Linkedin](https://www.linkedin.com/in/mantonishin/)

## Description
@TODO Add description.

## Requirements
- PHP 7.2+

## Installation 
@TODO Add installation description.

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
- `domainLength` - Number of chars to be replaced.
- `domainOffset` - Number of chars to be skipped to replace.

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

@TODO Add all requirements.

@TODO Add more information 