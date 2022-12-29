<?php

declare(strict_types=1);

namespace Nip\View\Extensions;

use League\Plates\Engine;
use League\Plates\Template\Template;
use Nip\View\View;

/**
 * Class AbstractExtension.
 */
abstract class AbstractExtension implements \League\Plates\Extension\ExtensionInterface
{
    /**
     * Instance of the current template.
     */
    public Template $template;

    protected View $engine;

    public function register(View|Engine $engine)
    {
        $this->engine = $engine;
    }
}
