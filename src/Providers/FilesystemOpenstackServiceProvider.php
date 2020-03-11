<?php

namespace Webparking\FilesystemOpenstack\Providers;

use GuzzleHttp\HandlerStack;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Nimbusoft\Flysystem\OpenStack\SwiftAdapter;
use OpenStack\Common\Transport\Utils;
use OpenStack\Identity\v2\Service;

class FilesystemOpenstackServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $filesystem = $this->app->make('filesystem');

        $filesystem->extend('openstack', function ($app, $config) {
            $openstack = new \OpenStack\OpenStack($this->buildParameters($config));
            $container = $openstack->objectStoreV1()->getContainer($config['container']);
            $adapter = new SwiftAdapter($container);
            $flysystem = new Filesystem($adapter);

            return $flysystem;
        });
    }

    private function buildParameters($config): array
    {
        $parameters = [
            'username' => $config['username'],
            'password' => $config['password'],
            'tenantId' => $config['tenant_id'],
            'tenantName' => $config['tenant_name'],
            'authUrl' => $config['auth_url'],
            'region' => $config['region'],
        ];

        if ('v2' === $config['id_version']) {
            $parameters['identityService'] = Service::factory(
                new \GuzzleHttp\Client([
                    'base_uri' => Utils::normalizeUrl($config['auth_url']),
                    'handler' => HandlerStack::create(),
                ])
            );
        }

        return $parameters;
    }
}
