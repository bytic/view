<?php

namespace Nip\View\Traits;

/**
 * Trait HasHelpersTrait
 * @package Nip\View\Traits
 *
 * @method Nip\Helpers\View\Breadcrumbs Breadcrumbs()
 * @method Nip\Helpers\View\Doctype Doctype()
 * @method Nip\Helpers\View\Flash Flash()
 * @method Nip\Helpers\View\FacebookMeta FacebookMeta()
 * @method Nip\Helpers\View\GoogleAnalytics GoogleAnalytics()
 * @method Nip\Helpers\View\HTML HTML()
 * @method Nip\Helpers\View\Messages Messages()
 * @method Nip\Helpers\View\Meta Meta()
 * @method Nip\Helpers\View\Paginator Paginator()
 * @method Nip\Helpers\View\Scripts Scripts()
 * @method Nip\Helpers\View\Stylesheets Stylesheets()
 * @method Nip\Helpers\View\TinyMCE TinyMCE()
 * @method Nip\Helpers\View\Url Url()
 * @method Nip\Helpers\View\GoogleDFP GoogleDFP()
 */
trait HasHelpersTrait
{

    protected $helpers = [];

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
        return '\Nip\Helpers\View\\' . $name;
    }
}
