<?php

namespace Nip\View\Extensions\Helpers;

use Nip\View\Helpers\DoctypeHelper;

/**
 * Trait HasHelpersTrait
 * @package Nip\View\Traits
 *
 * @method hasHelper($name)
 * @method getHelper($name)
 *
 * @method DoctypeHelper Doctype()
 *
 * @method Helpers\View\Breadcrumbs Breadcrumbs()
 * @method Helpers\View\Flash Flash()
 * @method Helpers\View\FacebookMeta FacebookMeta()
 * @method Helpers\View\GoogleAnalytics GoogleAnalytics()
 * @method Helpers\View\HTML HTML()
 * @method Helpers\View\Messages Messages()
 * @method Helpers\View\Meta Meta()
 * @method Helpers\View\Paginator Paginator()
 * @method Helpers\View\Scripts Scripts()
 * @method Helpers\View\Stylesheets Stylesheets()
 * @method Helpers\View\TinyMCE TinyMCE()
 * @method Helpers\View\Url Url()
 * @method Helpers\View\GoogleDFP GoogleDFP()
 */
trait HasHelpersTrait
{

    public function addHelpersExtension()
    {
        $this->register(new HelpersExtension());
    }
}
