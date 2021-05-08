<?php

namespace Nip\View\Extensions;

use League\Plates\Engine;
use Nip\View;
use Nip\View\Extensions\AbstractExtension;
use Nip\View\Helpers\HelpersCollection;
use Nip\View\Traits\HasMethodsTrait;
use Nip\View\Traits\MethodsOverloadingTrait;
use Nip\View\ViewInterface;

/**
 * Class LegacyLoadExtension
 * @package Nip\View\Extensions
 */
class LegacyLoadExtension extends AbstractExtension
{
    /**
     * @param ViewInterface|MethodsOverloadingTrait|HasMethodsTrait|View $engine
     * @return void
     */
    public function register(Engine $engine)
    {
        $engine->registerFunction('load', function (...$arguments) use ($engine) {
            $content = $engine->getContents(...$arguments);
            if (isset($arguments[3]) && $arguments[3] === true) {
                return $content;
            }
            echo $content;
        });
    }
}
