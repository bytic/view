<?php
declare(strict_types=1);

namespace Nip\View\Extensions;

use League\Plates\Engine;
use Nip\View;
use Nip\View\Traits\HasMethodsTrait;
use Nip\View\ViewInterface;

/**
 * Class LegacyLoadExtension
 * @package Nip\View\Extensions
 */
class LegacyLoadExtension extends AbstractExtension
{
    /**
     * @param ViewInterface|HasMethodsTrait|View $engine
     * @return void
     */
    public function register(Engine $engine)
    {
        $engine->registerFunction('load', function (...$arguments) use ($engine) {
            $view = array_shift($arguments);
            $variables = array_shift($arguments);
            $return = array_shift($arguments);
            if (is_array($view)) {
                $view = $engine->buildPath($view);
            }
            $variables = is_array($variables) ? $variables : [];

            $content = $engine->getContents($view, $variables);
            if ($return === true) {
                return $content;
            }
            echo $content;
        });
    }
}
