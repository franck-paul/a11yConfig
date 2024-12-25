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

use Dotclear\Core\Process;

class Prepend extends Process
{
    // Constants for position (public/admin)
    final public const IN_TOP = 0;

    final public const IN_BOTTOM = 1;

    // Constants for icon (public/admin)
    final public const ICON_NONE = 0;

    final public const ICON_WHEELCHAIR = 1;

    final public const ICON_VISUALDEFICIENCY = 2;

    public static function init(): bool
    {
        return self::status(My::checkContext(My::PREPEND));
    }

    public static function process(): bool
    {
        return (bool) self::status();
    }
}
