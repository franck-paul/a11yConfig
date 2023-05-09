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

        dcCore::app()->addBehaviors([
            'publicHeadContent'     => [Frontendbehaviors::class, 'publicHeadContent'],
            'publicTopAfterContent' => [Frontendbehaviors::class, 'publicTopAfterContent'],
            'publicFooterContent'   => [Frontendbehaviors::class, 'publicFooterContent'],

            'initWidgets'        => [Widgets::class, 'initWidgets'],
            'initDefaultWidgets' => [Widgets::class, 'initDefaultWidgets'],
        ]);

        dcCore::app()->tpl->addValue('AccessConfig', [FrontendTemplate::class, 'tplAccessConfig']);

        return true;
    }
}
