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

use dcNsProcess;

class Prepend extends dcNsProcess
{
    // Constants for position (public/admin)
    public const IN_TOP    = 0;
    public const IN_BOTTOM = 1;

    // Constants for icon (public/admin)
    public const ICON_NONE             = 0;
    public const ICON_WHEELCHAIR       = 1;
    public const ICON_VISUALDEFICIENCY = 2;

    public static function init(): bool
    {
        static::$init = defined('DC_RC_PATH');

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        return true;
    }
}
