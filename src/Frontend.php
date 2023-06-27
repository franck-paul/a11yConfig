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
use dcNsProcess;

class Frontend extends dcNsProcess
{
    protected static $init = false; /** @deprecated since 2.27 */
    public static function init(): bool
    {
        static::$init = My::checkContext(My::FRONTEND);

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        $settings = dcCore::app()->blog->settings->get(My::id());
        if (!(bool) $settings->active) {
            return false;
        }

        dcCore::app()->addBehaviors([
            'publicHeadContent'     => [FrontendBehaviors::class, 'publicHeadContent'],
            'publicTopAfterContent' => [FrontendBehaviors::class, 'publicTopAfterContent'],
            'publicFooterContent'   => [FrontendBehaviors::class, 'publicFooterContent'],

            'initWidgets'        => [Widgets::class, 'initWidgets'],
            'initDefaultWidgets' => [Widgets::class, 'initDefaultWidgets'],
        ]);

        dcCore::app()->tpl->addValue('AccessConfig', [FrontendTemplate::class, 'tplAccessConfig']);

        return true;
    }
}
