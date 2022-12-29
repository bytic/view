<?php

declare(strict_types=1);

namespace Nip\View\Helpers;

use Nip\View\View;

/**
 * Nip Framework.
 *
 * @category   Nip
 *
 * @copyright  2009 Nip Framework
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 * @version    SVN: $Id: Abstract.php 14 2009-04-13 11:24:22Z victor.stanciu $
 */
abstract class AbstractHelper
{
    protected $view;

    public function setView(View $view)
    {
        $this->view = $view;
    }

    public function getView()
    {
        return $this->view;
    }
}
