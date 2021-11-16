<?php

namespace EmailDomain\Eloquent;

use EmailDomain\Facades\EmailDomainChecker;
use Illuminate\Support\Str;

trait HasEmailDomainChecker
{
    public function hasPublicEmailProviderDomain(?string $email = null): bool
    {
        $email = $this->getEmailProviderDomain($email);

        return $email ? EmailDomainChecker::usePublicProviderDomainsFile()->isDomainInList($email) : false;
    }

    /**
     * Get email provider domain.
     *
     * @param string|null $email
     *
     * @return string
     */
    public function getEmailProviderDomain(?string $email = null): string
    {
        $email = $email ?? $this->{$this->emailKeyForDomainChecker()};
        if ($email = filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return Str::afterLast($email, '@');
        }

        return '';
    }

    /**
     * Field key name.
     *
     * @return string
     */
    public function emailKeyForDomainChecker(): string
    {
        return property_exists($this, 'emailKeyForDomainChecker') ? $this->emailKeyForDomainChecker : 'email';
    }
}
