<?php
declare(strict_types=1);

namespace Nip\View;

use ArrayAccess;
use Nip\View\Extensions\Helpers\HasHelpersTrait;
use Nip\View\Extensions\LegacyLoadExtension;
use Nip\View\ResolveTemplatePath\HasViewFinder;
use Nip\View\ResolveTemplatePath\ThemeFolderResolveTemplatePath;

/**
 * Class View
 *
 */
class View extends \League\Plates\Engine implements ViewInterface, ArrayAccess
{
    use Traits\CanRenderTrait;
    use Traits\HasDataTrait;
    use Traits\HasExtensionsTrait;
    use HasHelpersTrait;
    use Traits\HasMethodsTrait;
    use Traits\HasPathsTrait;
    use Traits\HasRequestTrait;

    use HasViewFinder;

    protected $helpers = [];
    protected $blocks = [];

    /**
     * @inheritDoc
     */
    public function __construct($directory = null, $fileExtension = 'php')
    {
        parent::__construct($directory, $fileExtension);
        $this->addHelpersExtension();
        $this->loadExtension(new LegacyLoadExtension());
        $this->setResolveTemplatePath(new ThemeFolderResolveTemplatePath($this));
//        $this->initFinder();
    }

}
