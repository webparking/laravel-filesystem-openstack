# Laravel filesystem wrapper for Openstack swift
This package replaced the not actively maintained https://github.com/neoxia/laravel-openstack and is a wrapper for https://github.com/chrisnharvey/flysystem-openstack-swift. Main motivation was the need to use it in a Laravel 7 & 8 projects and the switch from a deeper dependency on `guzzle/guzzle` to `guzzlehttp/guzzle`.

## Installation
```
composer require webparking/laravel-filesystem-openstack
```

## Usage
To configure a new Laravel storage disk on OpenStack, provide a configuration like this one in config/filesystems.php

    'disks' => [
        'openstack' => [
            'driver'        => 'openstack',
            'auth_url'      => env('OS_AUTH_URL', ''),
            'username'      => env('OS_USERNAME', ''),
            'password'      => env('OS_PASSWORD', ''),
            'tenant_id'     => env('OS_TENANT_ID', ''),
            'tenant_name'   => env('OS_TENANT_NAME', ''),
            'container'     => env('OS_CONTAINER', ''),
            'region'        => env('OS_REGION', ''),
            'id_version     => 'v3' // Supported identity version v2 & v3 (default)
        ],
    ],
    
Note that the implementation of OpenStack Object Storage varies from one provider to an other. For instance, the configuration of the tenant_id and/or of the tenant_name is not always mandatory.

## Licence and Postcardware

This software is open source and licensed under the [MIT license](LICENSE.md).

If you use this software in your daily development we would appreciate to receive a postcard of your hometown.

Please send it to: Webparking BV, Cypresbaan 31a, 2908 LT Capelle aan den IJssel, The Netherlands
