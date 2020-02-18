<?php

namespace Nip\View\Extensions\Helpers;

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
     * @param ViewInterface|MethodsOverloadingTrait|HasMethodsTrait|View $view
     * @return void
     */
    public function register(ViewInterface $view)
    {
        $view->getCallPipelineBuilder()->add(new HelpersPipelineStage());
        HelpersCollection::getInstance()->setEngine($view);

        $view->addMethod('getHelper', function ($name) {
            return HelpersCollection::getInstance()->getHelper($name);
        });

        $view->addMethod('hasHelper', function ($name) {
            return HelpersCollection::getInstance()->hasHelper($name);
        });
    }
}
