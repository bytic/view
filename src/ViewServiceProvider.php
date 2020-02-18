<?php

namespace Nip\View;

use Nip\Container\ServiceProviders\Providers\AbstractServiceProvider;

/**
 * Class ViewServiceProvider
 * @package Nip\View
 */
class ViewServiceProvider extends AbstractServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactory();
    }

    public function registerFactory()
    {
        $this->getContainer()->singleton('view.factory', ViewFactory::class);
    }


    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['view', 'view.finder', 'view.factory'];
    }
}
