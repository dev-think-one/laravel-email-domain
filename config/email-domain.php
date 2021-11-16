<?php

return [
    'storage_path' => env('EMAIL_DOMAIN_STORAGE_PATH', storage_path('framework/email-domain')),

    'domains_group_files' => [
        'public_provider_domains' => env('EMAIL_DOMAIN_GROUP_PUBLIC_PROVIDERS', 'public_provider_domains.txt'),
    ],

    'checker' => [
        'filter_domain' => env('EMAIL_DOMAIN_FILTER_DOMAIN', true),
        'regex_pattern' => env('EMAIL_DOMAIN_REGEX_PATTERN', "/^\s*<DOMAIN>\s*$/m"),
    ],
];
