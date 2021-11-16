<?php

namespace EmailDomain\Tests;

use EmailDomain\Tests\Fixtures\Models\Contact;

class HasEmailDomainCheckerTest extends TestCase
{


    /** @test */
    public function has_default_email_key()
    {
        $contact = Contact::fake();

        $this->assertEquals('email', $contact->emailKeyForDomainChecker());
    }

    /** @test */
    public function get_email_provider_domain()
    {
        $email   = 'test@gmail.com';
        $contact = Contact::fake(['email' => $email]);

        $this->assertEquals('gmail.com', $contact->getEmailProviderDomain());
        $this->assertEquals('', $contact->getEmailProviderDomain('test@test@test.com'));
        $this->assertEquals('', $contact->getEmailProviderDomain('test.com'));
        $this->assertEquals('', Contact::fake(['email' => 'wrong@com,email'])->getEmailProviderDomain());
    }

    /** @test */
    public function has_public_email_provider_domain()
    {
        $email   = 'test@gmail.com';
        $contact = Contact::fake(['email' => $email]);

        $this->assertTrue($contact->hasPublicEmailProviderDomain());
        $this->assertTrue($contact->hasPublicEmailProviderDomain('test@1033edge.com'));
        $this->assertFalse($contact->hasPublicEmailProviderDomain('test@gmail.my.com'));
        $this->assertFalse($contact->hasPublicEmailProviderDomain('test@gmail@my.com'));
        $this->assertFalse(Contact::fake(['email' => 'wrong@com,email'])->hasPublicEmailProviderDomain());
    }
}
