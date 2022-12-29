<?php
declare(strict_types=1);

namespace Nip\View;

use ArrayAccess;
use League\Plates\Engine;
use Nip\View\Extensions\Helpers\HasHelpersTrait;
use Nip\View\Extensions\LegacyLoadExtension;
use Nip\View\Extensions\RenderConditions\RenderConditionsExtension;
use Nip\View\Legacy\Traits\ViewLegacyTrait;
use Nip\View\ResolveTemplatePath\HasViewFinder;
use Nip\View\ResolveTemplatePath\ThemeFolderResolveTemplatePath;

/**
 * Class View
 *
 */
class View extends Engine implements ViewInterface, ArrayAccess
{
    use Traits\CanRenderTrait;
    use Traits\HasDataTrait;
    use Traits\HasExtensionsTrait;
    use HasHelpersTrait;
    use Traits\HasMethodsTrait;
    use Traits\HasPathsTrait;
    use Traits\HasRequestTrait;

    use HasViewFinder;
    use ViewLegacyTrait;

    protected $helpers = [];

    /**
     * @inheritDoc
     */
    public function __construct($directory = null, $fileExtension = 'php')
    {
        parent::__construct($directory, $fileExtension);
        $this->addHelpersExtension();
        $this->loadExtension(new LegacyLoadExtension());
        $this->loadExtension(new RenderConditionsExtension());
        $this->setResolveTemplatePath(new ThemeFolderResolveTemplatePath($this));
        $this->initFinder();
    }

}
