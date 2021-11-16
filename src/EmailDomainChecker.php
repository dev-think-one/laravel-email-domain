<?php

namespace EmailDomain;

use EmailDomain\Exceptions\EmailDomainException;
use Illuminate\Support\Str;

/**
 * @method static usePublicProviderDomainsFile()
 */
class EmailDomainChecker
{
    protected string $storagePath = '';

    protected string $domainsFilePath = '';

    public function __construct(?string $storagePath = null)
    {
        $this->storagePath = $storagePath ?? config('email-domain.storage_path');
    }

    /**
     * @param string $storagePath
     *
     * @return $this
     */
    public function setStoragePath(string $storagePath): static
    {
        $this->storagePath = $storagePath;

        return $this;
    }

    /**
     * @return string
     */
    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    /**
     * @param string $domainsFilePath
     *
     * @return $this
     */
    public function setDomainsFilePath(string $domainsFilePath): static
    {
        $this->domainsFilePath = $domainsFilePath;

        return $this;
    }

    /**
     * @return string
     */
    public function getDomainsFilePath(): string
    {
        return $this->domainsFilePath;
    }


    /**
     * @param string|null $domainsFilePath
     *
     * @return string
     */
    public function absoluteFilePath(?string $domainsFilePath = null): string
    {
        $domainsFilePath = $domainsFilePath ?? $this->domainsFilePath;

        if (empty($domainsFilePath)) {
            throw new EmailDomainException('Domains list file path is empty');
        }

        return rtrim($this->storagePath, '/') . '/' . ltrim($domainsFilePath, '/');
    }

    /**
     * @param string|null $domainsFilePath
     *
     * @return string
     * @throws EmailDomainException
     */
    public function domainsList(?string $domainsFilePath = null): string
    {
        $domainsFilePath = $this->absoluteFilePath($domainsFilePath);

        if (!file_exists($domainsFilePath)) {
            throw new EmailDomainException("Domains list file path is wrong [{$domainsFilePath}]");
        }

        return file_get_contents($domainsFilePath);
    }

    /**
     * @param string $domain
     * @param string|null $domainsFilePath
     *
     * @return bool
     * @throws EmailDomainException
     */
    public function isDomainInList(string $domain, ?string $domainsFilePath = null): bool
    {
        if (config('email-domain.checker.filter_domain', true)) {
            if (!$domain = filter_var($domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
                return false;
            }
        }

        $domainRegex = str_replace('<DOMAIN>', preg_quote($domain), config('email-domain.checker.regex_pattern'));

        return preg_match($domainRegex, $this->domainsList($domainsFilePath));
    }

    public function __call(string $name, array $arguments)
    {
        if (Str::startsWith($name, 'use')
             && Str::endsWith($name, 'File')) {
            $group = Str::snake(Str::beforeLast(Str::after($name, 'use'), 'File'));
            if ($filePath = config("email-domain.domains_group_files.{$group}")) {
                $this->setDomainsFilePath($filePath);

                return $this;
            }
        }

        throw new \BadMethodCallException("Method [{$name}] not exists.");
    }
}
