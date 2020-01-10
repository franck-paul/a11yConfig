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

$core->addBehavior('adminPageHTMLHead', ['a11yconfigAdmin', 'adminPageHTMLHead']);

$core->addBehavior('adminBeforeUserOptionsUpdate', ['a11yconfigAdmin', 'adminBeforeUserOptionsUpdate']);
$core->addBehavior('adminPreferencesForm', ['a11yconfigAdmin', 'adminPreferencesForm']);

class a11yconfigAdmin
{
    public static function adminPageHTMLHead()
    {
        global $core;

        $core->auth->user_prefs->addWorkspace('a11yConfig');
        if ($core->auth->user_prefs->a11yConfig->active) {
            $version = $core->getVersion('a11yConfig');

            $class = '';
            switch ((integer) $core->auth->user_prefs->a11yConfig->icon) {
                case 1:
                    $class = 'a11yc-wc';
                    break;
                case 2:
                    $class = 'a11yc-vd';
                    break;
            }

            $data = [
                // AccessConfig Library data
                'options' => [
                    'Prefix'           => 'a42-ac',
                    'Modal'            => true,
                    'Font'             => (boolean) $core->auth->user_prefs->a11yConfig->font,
                    'LineSpacing'      => (boolean) $core->auth->user_prefs->a11yConfig->linespacing,
                    'Justification'    => (boolean) $core->auth->user_prefs->a11yConfig->justification,
                    'Contrast'         => (boolean) $core->auth->user_prefs->a11yConfig->contrast,
                    'ImageReplacement' => (boolean) $core->auth->user_prefs->a11yConfig->image
                ],
                // Plugin specific data
                'label'   => $core->auth->user_prefs->a11yConfig->label,
                'class'   => $class,
                'parent'  => (integer) $core->auth->user_prefs->a11yConfig->position === 0 ? 'ul#top-info-user' : 'footer',
                'element' => (integer) $core->auth->user_prefs->a11yConfig->position === 0 ? 'li' : 'div'
            ];
            echo dcPage::jsJson('a11yc', $data);

            echo
            dcPage::cssLoad(urldecode(dcPage::getPF('a11yConfig/lib/css/accessconfig.min.css')), 'screen', $version) .
            dcPage::cssLoad(urldecode(dcPage::getPF('a11yConfig/css/admin.css')), 'screen', $version) .
            dcPage::jsLoad(urldecode(dcPage::getPF('a11yConfig/js/admin.js')), $version) .
            dcPage::jsLoad(urldecode(dcPage::getPF('a11yConfig/lib/js/accessconfig.min.js')), $version);
        }
    }

    public static function adminBeforeUserOptionsUpdate($cur, $userID)
    {
        global $core;

        // Get and store user's prefs for plugin options
        $core->auth->user_prefs->addWorkspace('a11yConfig');
        try {
            $core->auth->user_prefs->a11yConfig->put('active', !empty($_POST['a11yc_active']), 'boolean');

            $core->auth->user_prefs->a11yConfig->put('label', html::escapeHTML($_POST['a11yc_label']), 'string');
            $core->auth->user_prefs->a11yConfig->put('icon', abs((integer) $_POST['a11yc_icon']), 'integer');
            $core->auth->user_prefs->a11yConfig->put('position', abs((integer) $_POST['a11yc_position']), 'integer');

            $core->auth->user_prefs->a11yConfig->put('font', !empty($_POST['a11yc_font']), 'boolean');
            $core->auth->user_prefs->a11yConfig->put('linespacing', !empty($_POST['a11yc_linespacing']), 'boolean');
            $core->auth->user_prefs->a11yConfig->put('justification', !empty($_POST['a11yc_justification']), 'boolean');
            $core->auth->user_prefs->a11yConfig->put('contrast', !empty($_POST['a11yc_contrast']), 'boolean');
            $core->auth->user_prefs->a11yConfig->put('image', !empty($_POST['a11yc_image']), 'boolean');
        } catch (Exception $e) {
            $core->error->add($e->getMessage());
        }
    }

    public static function adminPreferencesForm($core)
    {
        $a11yc_positions = [
            0 => __('In admin header'),
            1 => __('In admin footer')
        ];

        $a11yc_icons = [
            0 => __('No'),
            1 => __('Wheelchair'),
            2 => __('Visual deficiency')
        ];

        // Get user's prefs for plugin options
        $core->auth->user_prefs->addWorkspace('a11yConfig');

        $a11yc_active = (boolean) $core->auth->user_prefs->a11yConfig->active;

        $a11yc_label    = $core->auth->user_prefs->a11yConfig->label;
        $a11yc_icon     = (integer) $core->auth->user_prefs->a11yConfig->icon;
        $a11yc_position = (integer) $core->auth->user_prefs->a11yConfig->position;

        $a11yc_font          = (boolean) $core->auth->user_prefs->a11yConfig->font;
        $a11yc_linespacing   = (boolean) $core->auth->user_prefs->a11yConfig->linespacing;
        $a11yc_justification = (boolean) $core->auth->user_prefs->a11yConfig->justification;
        $a11yc_contrast      = (boolean) $core->auth->user_prefs->a11yConfig->contrast;
        $a11yc_image         = (boolean) $core->auth->user_prefs->a11yConfig->image;

        echo
        '<div class="fieldset" id="a11yConfig"><h5>' . __('a11yConfig') . '</h5>';

        echo
        '<p>' . form::checkbox('a11yc_active', 1, $a11yc_active) . ' ' .
        '<label for="a11yc_active" class="classic">' . __('Active a11yConfig') . '</label></p>';

        echo
        '<p><label for="a11yc_label" class="required" title="' . __('Required field') . '"><abbr title="' . __('Required field') . '">*</abbr> ' . __('Label:') . '</label> ' .
        form::field('a11yc_label', 30, 256, html::escapeHTML($a11yc_label), '', '', false, 'required placeholder="' . __('Accessibility parameters') . '"') .
            '</p>';

        // Options for button appearance
        echo '<h6>' . __('Icon:') . '</h6>';
        echo
        '<p class="form-note">' . __('The previous label will be used as alternative text if one of proposed icons is choosen.') . '</p>';
        $i = 0;
        foreach ($a11yc_icons as $k => $v) {
            echo '<p><label for="a11yc_icon_' . $i . '" class="classic">' .
            form::radio(['a11yc_icon', 'a11yc_icon_' . $i], $k, $a11yc_icon == $k) . ' ' . $v . '</label></p>';
            $i++;
        }

        // Options for automatic insertion
        echo '<h6>' . __('Position:') . '</h6>';
        $i = 0;
        foreach ($a11yc_positions as $k => $v) {
            echo '<p><label for="a11yc_position_' . $i . '" class="classic">' .
            form::radio(['a11yc_position', 'a11yc_position_' . $i], $k, $a11yc_position == $k) . ' ' . $v . '</label></p>';
            $i++;
        }

        echo '<h6>' . __('Options:') . '</h6>';
        echo
        '<p>' . form::checkbox('a11yc_font', 1, $a11yc_font) . ' ' .
        '<label for="a11yc_font" class="classic">' . __('Font adaptation') . '</label></p>' .
        '<p>' . form::checkbox('a11yc_linespacing', 1, $a11yc_linespacing) . ' ' .
        '<label for="a11yc_linespacing" class="classic">' . __('Line Spacing adaptation') . '</label></p>' .
        '<p>' . form::checkbox('a11yc_justification', 1, $a11yc_justification) . ' ' .
        '<label for="a11yc_justification" class="classic">' . __('Justification adaptation') . '</label></p>' .
        '<p>' . form::checkbox('a11yc_contrast', 1, $a11yc_contrast) . ' ' .
        '<label for="a11yc_contrast" class="classic">' . __('Contrast adaptation') . '</label></p>' .
        '<p>' . form::checkbox('a11yc_image', 1, $a11yc_image) . ' ' .
        '<label for="a11yc_image" class="classic">' . __('Image replacement') . '</label></p>';

        echo
            '</div>';
    }
}
