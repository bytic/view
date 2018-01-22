<?php

namespace Nip\View\Traits;

/**
 * Trait HasHelpersTrait
 * @package Nip\View\Traits
 *
 * @method Helpers\View\Breadcrumbs Breadcrumbs()
 * @method Helpers\View\Doctype Doctype()
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

    /**
     * @param $name
     * @return mixed
     */
    public function getHelper($name)
    {
        if (!isset($this->helpers[$name])) {
            $this->initHelper($name);
        }

        return $this->helpers[$name];
    }

    /**
     * @param $name
     */
    public function initHelper($name)
    {
        $this->helpers[$name] = $this->newHelper($name);
    }

    /**
     * @param $name
     * @return Helpers\View\AbstractHelper
     */
    public function newHelper($name)
    {
        $class = $this->getHelperClass($name);
        $helper = new $class();
        /** @var \Nip\Helpers\View\AbstractHelper $helper */
        $helper->setView($this);

        return $helper;
    }

    /**
     * @param $name
     * @return string
     */
    public function getHelperClass($name)
    {
        return '\Nip\Helpers\View\\'.$name;
    }
}
