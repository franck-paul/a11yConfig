<?php
/**
 * @brief a11yConfig, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul, Biou and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\a11yConfig;

use dcAdmin;
use dcAuth;
use dcCore;
use dcNsProcess;
use dcPage;

class Backend extends dcNsProcess
{
    public static function init(): bool
    {
        static::$init = defined('DC_CONTEXT_ADMIN');

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        dcCore::app()->menu[dcAdmin::MENU_BLOG]->addItem(
            __('Accessibility'),
            'plugin.php?p=' . My::id(),
            [urldecode(dcPage::getPF(My::id() . '/icon.svg')),urldecode(dcPage::getPF(My::id() . '/icon-dark.svg'))],
            preg_match('/plugin.php\?p=' . My::id() . '(&.*)?$/', $_SERVER['REQUEST_URI']),
            dcCore::app()->auth->check(dcCore::app()->auth->makePermissions([
                dcAuth::PERMISSION_ADMIN,
            ]), dcCore::app()->blog->id)
        );

        dcCore::app()->addBehaviors([
            'adminPageHTMLHead' => [BackendBehaviors::class, 'adminPageHTMLHead'],

            'adminBeforeUserOptionsUpdate' => [BackendBehaviors::class, 'adminBeforeUserOptionsUpdate'],
            'adminPreferencesFormV2'       => [BackendBehaviors::class, 'adminPreferencesForm'],
            'adminPreferencesHeaders'      => [BackendBehaviors::class, 'adminPreferencesHeaders'],

            'initWidgets'        => [Widgets::class, 'initWidgets'],
            'initDefaultWidgets' => [Widgets::class, 'initDefaultWidgets'],
        ]);

        return true;
    }
}
