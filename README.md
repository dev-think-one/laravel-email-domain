# Check email domain.

[![Packagist License](https://img.shields.io/packagist/l/yaroslawww/laravel-email-domain?color=%234dc71f)](https://github.com/yaroslawww/laravel-email-domain/blob/master/LICENSE.md)
[![Packagist Version](https://img.shields.io/packagist/v/yaroslawww/laravel-email-domain)](https://packagist.org/packages/yaroslawww/laravel-email-domain)
[![Total Downloads](https://img.shields.io/packagist/dt/yaroslawww/laravel-email-domain)](https://packagist.org/packages/yaroslawww/laravel-email-domain)
[![Build Status](https://scrutinizer-ci.com/g/yaroslawww/laravel-email-domain/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/laravel-email-domain/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/yaroslawww/laravel-email-domain/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/laravel-email-domain/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yaroslawww/laravel-email-domain/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/laravel-email-domain/?branch=master)

## Installation

Install the package via composer:

```bash
composer require yaroslawww/laravel-email-domain
```

You can publish the config and assets files with:

```bash
php artisan vendor:publish --provider="EmailDomain\ServiceProvider" --tag="config"
php artisan vendor:publish --provider="EmailDomain\ServiceProvider" --tag="storage"
```

## Usage

Example usage:

```injectablephp
EmailDomainChecker::setDomainsFilePath('path/to.file')->isDomainInList('gmail.com');
EmailDomainChecker::usePublicProviderDomainsFile()->isDomainInList('gmail.com');
```

Trait usage:

```injectablephp
class User extends Model
{
    use HasEmailDomainChecker;
}

$user->email = 'test@gmail.com';

$user->getEmailProviderDomain(); // gmail.com
$user->hasPublicEmailProviderDomain(); // true
```

## Credits

- [![Think Studio](https://yaroslawww.github.io/images/sponsors/packages/logo-think-studio.png)](https://think.studio/)
