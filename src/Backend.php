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

use dcCore;
use Dotclear\Core\Backend\Menus;
use Dotclear\Core\Process;

class Backend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::BACKEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        My::addBackendMenuItem(Menus::MENU_BLOG);

        dcCore::app()->addBehaviors([
            'adminPageHTMLHead' => BackendBehaviors::adminPageHTMLHead(...),

            'adminBeforeUserOptionsUpdate' => BackendBehaviors::adminBeforeUserOptionsUpdate(...),
            'adminPreferencesFormV2'       => BackendBehaviors::adminPreferencesForm(...),
            'adminPreferencesHeaders'      => BackendBehaviors::adminPreferencesHeaders(...),
        ]);

        if (My::checkContext(My::WIDGETS)) {
            dcCore::app()->addBehaviors([
                'initWidgets'        => Widgets::initWidgets(...),
                'initDefaultWidgets' => Widgets::initDefaultWidgets(...),
            ]);
        }

        return true;
    }
}
