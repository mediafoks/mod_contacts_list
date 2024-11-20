<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_contacts_list
 *
 * @copyright   (C) 2024 Sergey Kuznetsov
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Module\ContactsList\Site\Helper;

use Joomla\Database\DatabaseAwareInterface;
use Joomla\Database\DatabaseAwareTrait;
use Joomla\Utilities\ArrayHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Helper for mod_contacts_list
 *
 * @since  1.0.0
 */
class ContactsListHelper implements DatabaseAwareInterface
{
    use DatabaseAwareTrait;

    public function getContacts($params): array
    {
        $db = $this->getDatabase();

        $catId = join(',', $params->get('catid'));
        $count = $params->get('count');
        $exclude = ArrayHelper::fromObject($params->get('excluded_contacts'));
        $sort = $params->get('contact_ordering');

        $contactsExcludedList = [];

        foreach ($exclude as $contact) {
            $contactsExcludedList[] = (int) $contact['id'];
        }

        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__contact_details'))
            ->where('published=1')
            ->where('catid IN (' . $catId . ')')
            ->where('id NOT IN (' . implode(',', $contactsExcludedList) . ')')
            ->order($sort)
            ->setLimit($count);

        // Prepare the query

        $db->setQuery($query);
        // Load the row.
        $result = $db->loadObjectList();
        // Return the result
        return $result;
    }
}
