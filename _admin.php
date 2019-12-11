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

if (!defined('DC_CONTEXT_ADMIN')) {return;}

require dirname(__FILE__) . '/_widgets.php';

$_menu['Blog']->addItem(__('a11yConfig'), 'plugin.php?p=a11yConfig', urldecode(dcPage::getPF('a11yConfig/icon.png')),
    preg_match('/plugin.php\?p=a11yConfig(&.*)?$/', $_SERVER['REQUEST_URI']),
    $core->auth->check('admin', $core->blog->id));

$core->addBehavior('adminBlogPreferencesForm', ['a11yconfigAdminBehaviors', 'adminBlogPreferencesForm']);
$core->addBehavior('adminBeforeBlogSettingsUpdate', ['a11yconfigAdminBehaviors', 'adminBeforeBlogSettingsUpdate']);
