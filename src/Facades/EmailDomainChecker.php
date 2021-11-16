<?php

namespace EmailDomain\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \EmailDomain\EmailDomainChecker usePublicProviderDomainsFile()
 */
class EmailDomainChecker extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'email-domain-checker';
    }
}
