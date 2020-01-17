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

if (!defined('DC_RC_PATH')) {return;}
// public

class a11yconfigConst
{

    // Constants for position (public/admin)
    const IN_TOP    = 0;
    const IN_BOTTOM = 1;

    // Constants for icon (public/admin)
    const ICON_NONE             = 0;
    const ICON_WHEELCHAIR       = 1;
    const ICON_VISUALDEFICIENCY = 2;
}

if (!defined('DC_CONTEXT_ADMIN')) {return false;}
// admin
