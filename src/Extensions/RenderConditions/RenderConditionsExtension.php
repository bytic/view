<?php

declare(strict_types=1);

namespace Nip\View\Extensions\RenderConditions;

use League\Plates\Engine;
use Nip\View\Extensions\AbstractExtension;
use Nip\View\View;
use function is_callable;

class RenderConditionsExtension extends AbstractExtension
{
    public function register(View|Engine $engine)
    {
        parent::register($engine);
        $engine->addMethod('loadIfExists', [$this, 'loadIfExists']);
        $engine->addMethod('loadIf', [$this, 'loadIf']);
        $engine->addMethod('loadWithFallback', [$this, 'loadWithFallback']);
    }

    /**
     * @param array $variables
     * @param bool $return
     *
     * @return bool|string|void|null
     */
    public function loadIfExists($view, $variables = [], $return = false)
    {
        return $this->loadIf($this->existPath($view), $view, $variables, $return);
    }

    /**
     * @param bool|callable $condition
     * @param array $variables
     *
     * @return bool|string|void|null
     */
    public function loadIf($condition, $view, $variables = [])
    {
        $condition = is_callable($condition) ? $condition() : $condition;
        if (false == $condition) {
            return;
        }

        return $this->template->fetch($view, $variables);
    }

    protected function existPath($view): bool
    {
        return $this->engine->existPath($view);
    }

    /**
     * @param array $variables
     * @param bool $return
     *
     * @return bool|string|void|null
     */
    public function loadWithFallback($view, $fallback, $variables = [], $return = false)
    {
        $view = $this->existPath($view) ? $view : $fallback;

        return $this->template->fetch($view, $variables, $return);
    }
}
