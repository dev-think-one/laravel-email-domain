# Check email domain.

![Packagist License](https://img.shields.io/packagist/l/think.studio/laravel-email-domain?color=%234dc71f)
[![Packagist Version](https://img.shields.io/packagist/v/think.studio/laravel-email-domain)](https://packagist.org/packages/think.studio/laravel-email-domain)
[![Total Downloads](https://img.shields.io/packagist/dt/think.studio/laravel-email-domain)](https://packagist.org/packages/think.studio/laravel-email-domain)
[![Build Status](https://scrutinizer-ci.com/g/dev-think-one/laravel-email-domain/badges/build.png?b=main)](https://scrutinizer-ci.com/g/dev-think-one/laravel-email-domain/build-status/main)
[![Code Coverage](https://scrutinizer-ci.com/g/dev-think-one/laravel-email-domain/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/dev-think-one/laravel-email-domain/?branch=main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dev-think-one/laravel-email-domain/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/dev-think-one/laravel-email-domain/?branch=main)

## Installation

Install the package via composer:

```bash
composer require think.studio/laravel-email-domain
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

$email = 'test@gmail.com';
EmailDomainChecker::usePublicProviderDomainsFile()->isDomainInList(Str::afterLast($email, '@'));
EmailDomainChecker::usePublicProviderDomainsFile()->isEmailDomainInList($email);

// You can add your own groups in config `email-domain.domains_group_files` to check other groups
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
