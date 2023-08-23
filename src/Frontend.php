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
use Dotclear\Core\Process;

class Frontend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::FRONTEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        $settings = My::settings();
        if (!(bool) $settings->active) {
            return false;
        }

        dcCore::app()->addBehaviors([
            'publicHeadContent'     => FrontendBehaviors::publicHeadContent(...),
            'publicTopAfterContent' => FrontendBehaviors::publicTopAfterContent(...),
            'publicFooterContent'   => FrontendBehaviors::publicFooterContent(...),

            'initWidgets'        => Widgets::initWidgets(...),
            'initDefaultWidgets' => Widgets::initDefaultWidgets(...),
        ]);

        dcCore::app()->tpl->addValue('AccessConfig', FrontendTemplate::tplAccessConfig(...));

        return true;
    }
}
