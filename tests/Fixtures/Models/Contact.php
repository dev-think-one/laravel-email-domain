<?php

namespace EmailDomain\Tests\Fixtures\Models;

use EmailDomain\Eloquent\HasEmailDomainChecker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Contact extends Model
{
    use HasEmailDomainChecker;

    protected $table = 'contacts';

    protected $guarded = [];

    public static function fake(array $atts = [])
    {
        return new static(array_merge([
            'name'  => Str::random(),
            'email' => Str::random() . 'domain.test',
        ], $atts));
    }
}
