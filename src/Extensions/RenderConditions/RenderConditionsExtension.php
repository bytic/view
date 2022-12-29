<?php
declare(strict_types=1);

namespace Nip\View\Extensions\RenderConditions;

use League\Plates\Engine;
use Nip\View\Extensions\AbstractExtension;
use Nip\View\View;

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
     * @param $view
     * @param array $variables
     * @param bool $return
     * @return bool|string|void|null
     */
    public function loadIfExists($view, $variables = [], $return = false)
    {
        return $this->loadIf($this->existPath($view), $view, $variables, $return);
    }

    /**
     * @param bool|Callable $condition
     * @param $view
     * @param array $variables
     * @return bool|string|void|null
     */
    public function loadIf($condition, $view, $variables = [])
    {
        $condition = is_callable($condition) ? $condition() : $condition;
        if ($condition == false) {
            return;
        }
        return $this->template->fetch($view, $variables);
    }

    protected function existPath($view): bool
    {
        return $this->engine->existPath($view);
    }

    /**
     * @param $view
     * @param array $variables
     * @param bool $return
     * @return bool|string|void|null
     */
    public function loadWithFallback($view, $fallback, $variables = [], $return = false)
    {
        $view = $this->existPath($view) ? $view : $fallback;
        return $this->template->fetch($view, $variables, $return);
    }
}
