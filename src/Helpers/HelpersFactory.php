<?php

namespace Nip\View\Helpers;

use Nip\View\Extensions\Helpers\HelperNotFoundException;

/**
 * Class HelpersFactory
 * @package Nip\View\Extensions\Helpers
 */
class HelpersFactory
{

    /**
     * @param $view
     * @param $name
     * @return mixed
     * @throws HelperNotFoundException
     */
    public static function create($view, $name)
    {
        $class = self::getHelperClass($name);
        if (!class_exists($class)) {
            throw new HelperNotFoundException("No helper name [{$name}] found for view engine.");
        }
        $helper = new $class();
        $helper->setView($view);

        return $helper;
    }

    /**
     * @param $name
     * @return string
     */
    public static function getHelperClass($name)
    {
        $classNameVariations = self::getHelperClassVariations($name);
        foreach ($classNameVariations as $nameVariation) {
            if (class_exists($nameVariation)) {
                return $nameVariation;
            }
        }
        return '\Nip\Helpers\View\\' . $name;
    }

    /**
     * @param string $name
     * @return string[]
     */
    public static function getHelperClassVariations($name)
    {
        return [
            '\Nip\View\Helpers\\'.$name.'Helper',
        ];
    }
}
