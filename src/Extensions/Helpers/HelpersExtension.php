<?php

namespace Nip\View\Extensions\Helpers;

use League\Plates\Engine;
use Nip\View;
use Nip\View\Extensions\AbstractExtension;
use Nip\View\Helpers\HelpersCollection;
use Nip\View\Traits\HasMethodsTrait;
use Nip\View\Traits\MethodsOverloadingTrait;
use Nip\View\ViewInterface;

/**
 * Class HelpersExtension
 * @package Nip\View\Extensions\Helpers
 */
class HelpersExtension extends AbstractExtension
{
    /**
     * @param ViewInterface|MethodsOverloadingTrait|HasMethodsTrait|View $engine
     * @return void
     */
    public function register(Engine $engine)
    {
        $helpersCollection = HelpersCollection::getInstance();
        $helpersCollection->setEngine($engine);

        $engine->addMethod('getHelper', function ($name) use ($helpersCollection) {
            return $helpersCollection->getHelper($name);
        });

        $engine->addMethod('hasHelper', function ($name) use ($helpersCollection) {
            return $helpersCollection->hasHelper($name);
        });
    }
}
