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

if (!defined('DC_CONTEXT_ADMIN')) {return;}
// admin

class a11yconfigAdminBehaviors
{
    public static function adminBlogPreferencesForm($core, $settings)
    {
        echo
        '<div class="fieldset"><h4 id="a11yc_prefs">' . __('a11yConfig') . '</h4>' .
        '<p>' . form::checkbox('a11yc_active', 1, $settings->a11yConfig->active) . ' ' .
        '<label for="a11yc_active" class="classic">' . __('Active a11yConfig') . '</label></p>' .
            '</div>';
    }

    public static function adminBeforeBlogSettingsUpdate($settings)
    {
        $settings->a11yConfig->put('active', !empty($_POST['a11yc_active']), 'boolean');
    }
}
