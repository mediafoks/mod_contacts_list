<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_contacts_list
 *
 * @copyright   (C) 2024 Sergey Kuznetsov
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\Component\Contact\Site\Helper\RouteHelper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Factory;

//$list - массив всех контактов.
if (!$list) return;

$app  = Factory::getApplication();
$doc  = $app->getDocument();
$doc->getWebAssetManager()->useStyle('mod_contacts_list.contacts-list');
?>

<ul class="contacts-list-mod">
    <?php foreach ($list as $contact): ?>
        <?php
        $contact->slug    = $contact->id . ':' . $contact->alias;
        $contact->link = Route::_(RouteHelper::getContactRoute($contact->slug, $contact->catid));
        ?>
        <li class="contacts-list-mod__item contact-mod">
            <a class="contact-mod__link" href="<?= $contact->link; ?>" title="<?= $contact->name; ?>">
                <?php if ((int) $params->get('show_image') === 1): ?>
                    <div class="contact-mod__img">
                        <?php echo LayoutHelper::render(
                            'joomla.html.image',
                            [
                                'src' => $contact->image,
                                'alt' => $contact->name,
                                'class' => 'contact-mod__image'
                            ]
                        ); ?>
                    </div>
                    <div class="contact-mod__body">
                        <h4 class="contact-mod__name"><?= $contact->name; ?></h4>
                        <div class="contact-mod__info">
                            <span class="contact-mod__position"><?= $contact->con_position; ?></span>
                        </div>
                    </div>
                <?php else: ?>
                    <h4 class="contact-mod__name"><?= $contact->name; ?></h4>
                    <div class="contact-mod__info">
                        <span class="contact-mod__position"><?= $contact->con_position; ?></span>
                    </div>
                <?php endif; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>