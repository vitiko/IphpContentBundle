<?php
/**
 * Created by Vitiko
 * Date: 25.06.12
 * Time: 15:29
 */

namespace Iphp\ContentBundle\Module;

use Iphp\CoreBundle\Module\Module;
use Iphp\ContentBundle\Admin\Extension\RubricAdminExtension;

/**
 * Module - content search
 */
class ContentSearchModule extends Module
{

    function __construct()
    {
        $this->setName('Content search');
        $this->allowMultiple = false;
    }

    protected function registerRoutes()
    {
        $this->addRoute('contentsearch', '/', array('_controller' => 'IphpContentBundle:Content:search'));
    }

    function getAdminExtension()
    {
        return new RubricAdminExtension;
    }

}
