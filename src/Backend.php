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
use dcCore;
use dcNsProcess;

class Backend extends dcNsProcess
{
    protected static $init = false; /** @deprecated since 2.27 */
    public static function init(): bool
    {
        static::$init = My::checkContext(My::BACKEND);

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        dcCore::app()->menu[dcAdmin::MENU_BLOG]->addItem(
            __('Accessibility'),
            My::makeUrl(),
            My::icons(),
            preg_match(My::urlScheme(), $_SERVER['REQUEST_URI']),
            My::checkContext(My::MENU)
        );

        dcCore::app()->addBehaviors([
            'adminPageHTMLHead' => [BackendBehaviors::class, 'adminPageHTMLHead'],

            'adminBeforeUserOptionsUpdate' => [BackendBehaviors::class, 'adminBeforeUserOptionsUpdate'],
            'adminPreferencesFormV2'       => [BackendBehaviors::class, 'adminPreferencesForm'],
            'adminPreferencesHeaders'      => [BackendBehaviors::class, 'adminPreferencesHeaders'],
        ]);

        if (My::checkContext(My::WIDGETS)) {
            dcCore::app()->addBehaviors([
                'initWidgets'        => [Widgets::class, 'initWidgets'],
                'initDefaultWidgets' => [Widgets::class, 'initDefaultWidgets'],
            ]);
        }

        return true;
    }
}
