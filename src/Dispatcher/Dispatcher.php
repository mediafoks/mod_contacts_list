<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_contacts_list
 *
 * @copyright   (C) 2024 Sergey Kuznetsov
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Module\ContactsList\Site\Dispatcher;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;
use Joomla\CMS\Helper\ModuleHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Dispatcher class for mod_contacts_list
 *
 * @since  1.1.0
 */
class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    /**
     * Returns the layout data.
     *
     * @return  array
     *
     * @since   1.1.0
     */

    protected function getLayoutData()
    {
        $data   = parent::getLayoutData();
        $params = $data['params'];

        $cacheParams               = new \stdClass();
        $cacheParams->cachemode    = 'id';
        $cacheParams->class        = $this->getHelperFactory()->getHelper('ContactsListHelper');
        $cacheParams->method       = 'getContacts';
        $cacheParams->methodparams = [$params, $data['app']];
        $cacheParams->modeparams   = md5(serialize([$this->module->module, $this->module->id]));

        $data['list'] = ModuleHelper::moduleCache($this->module, $params, $cacheParams);
        return $data;
    }
}
