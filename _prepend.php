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

if (!defined('DC_CONTEXT_ADMIN')) {return false;}
// admin

$__autoload['a11yconfigAdminBehaviors'] = dirname(__FILE__) . '/inc/a11yconfig.behaviors.php';
