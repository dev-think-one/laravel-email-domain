<?php

namespace EmailDomain\Tests;

use EmailDomain\Exceptions\EmailDomainException;
use EmailDomain\Facades\EmailDomainChecker;
use Illuminate\Support\Str;

class EmailDomainCheckerTest extends TestCase
{

    /** @test */
    public function has_default_storage_path()
    {
        $this->assertEquals(config('email-domain.storage_path'), EmailDomainChecker::getStoragePath());

        $this->assertEmpty(EmailDomainChecker::setStoragePath('')->getStoragePath());
        $this->assertEquals('/my/path', EmailDomainChecker::setStoragePath('/my/path')->getStoragePath());
    }

    /** @test */
    public function has_not_default_file_path()
    {
        $this->assertEmpty(EmailDomainChecker::getDomainsFilePath());

        $this->assertEquals('path/to.file', EmailDomainChecker::setDomainsFilePath('path/to.file')->getDomainsFilePath());
        $this->assertEmpty(EmailDomainChecker::setDomainsFilePath('')->getDomainsFilePath());
    }

    /** @test */
    public function get_absolute_file_path()
    {
        $checker = EmailDomainChecker::setStoragePath('/foo/bar/')->setDomainsFilePath('/path/to.file');

        $this->assertEquals('/foo/bar/path/to.file', $checker->absoluteFilePath());

        $this->assertEquals('/foo/bar/other/file.txt', $checker->absoluteFilePath('/other/file.txt'));
    }

    /** @test */
    public function has_predefined_files_groups()
    {
        $this->assertEquals('public_provider_domains.txt', EmailDomainChecker::usePublicProviderDomainsFile()->getDomainsFilePath());

        $this->expectException(\BadMethodCallException::class);
        EmailDomainChecker::usePublicProviderDomains();
    }

    /** @test */
    public function retrieve_domains_list()
    {
        EmailDomainChecker::usePublicProviderDomainsFile();

        $this->assertTrue(Str::contains(EmailDomainChecker::domainsList(), 'gmail.com'));
    }

    /** @test */
    public function retrieve_domains_list_exception_if_empty_path()
    {
        $this->expectException(EmailDomainException::class);
        $this->expectExceptionMessage('Domains list file path is empty');
        EmailDomainChecker::domainsList();
    }

    /** @test */
    public function retrieve_domains_list_exception_if_wrong_path()
    {
        $checker = EmailDomainChecker::setDomainsFilePath('path/to.file');
        $this->expectException(EmailDomainException::class);
        $this->expectExceptionMessage("Domains list file path is wrong [{$checker->absoluteFilePath()}]");
        $checker->domainsList();
    }

    /** @test */
    public function domains_checker()
    {
        EmailDomainChecker::usePublicProviderDomainsFile();

        $this->assertTrue(EmailDomainChecker::isDomainInList('gmail.com'));
        $this->assertFalse(EmailDomainChecker::isDomainInList('gmail.foo.com'));
        $this->assertFalse(EmailDomainChecker::isDomainInList('gmailcom'));
        $this->assertFalse(EmailDomainChecker::isDomainInList('gmail,com'));
    }
}
