<?php

namespace Nip\View\Helpers;

use Exception;

/**
 * Class DoctypeHelper
 * @package Nip\View\Helpers
 */
class DoctypeHelper extends AbstractHelper
{
    protected $docType;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @return string
     */
    public function render()
    {
        switch ($this->docType) {
            case 'XHTML11':
                return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';
            case 'XHTML1_STRICT':
                return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
            case 'XHTML1_FRAMESET':
                return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">';
            case 'XHTML_BASIC1':
                return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.0//EN" "http://www.w3.org/TR/xhtml-basic/xhtml-basic10.dtd">';
            case 'HTML4_STRICT':
                return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
            case 'HTML4_LOOSE':
                return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
            case 'HTML4_FRAMESET':
                return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">';
            case 'XHTML1_TRANSITIONAL':
                return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
            default:
                return '<!DOCTYPE html>';
        }
    }

    /**
     * @param bool $docType
     * @return $this
     * @throws Exception
     */
    public function set($docType = false)
    {
        switch ($docType) {
            case 'XHTML11':
            case 'XHTML1_STRICT':
            case 'XHTML1_TRANSITIONAL':
            case 'XHTML1_FRAMESET':
            case 'XHTML_BASIC1':
            case 'HTML4_STRICT':
            case 'HTML4_LOOSE':
            case 'HTML4_FRAMESET':
                $this->docType = $docType;
                break;
            default:
                throw new Exception('unknown doctype');
                break;
        }

        return $this;
    }
}
