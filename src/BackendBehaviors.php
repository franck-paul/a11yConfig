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
use dcPage;
use Dotclear\Helper\Html\Html;
use Exception;
use form;

class BackendBehaviors
{
    public static function adminPageHTMLHead()
    {
        $settings = dcCore::app()->auth->user_prefs->a11yConfig;

        if ($settings->active) {
            $version = dcCore::app()->getVersion(My::id());

            $class = '';
            switch ((int) $settings->icon) {
                case Prepend::ICON_WHEELCHAIR:
                    $class = 'a11yc-wc';

                    break;
                case Prepend::ICON_VISUALDEFICIENCY:
                    $class = 'a11yc-vd';

                    break;
            }

            $data = [
                // AccessConfig Library data
                'options' => [
                    'Prefix'           => 'a42-ac',
                    'Modal'            => true,
                    'Font'             => (bool) $settings->font,
                    'LineSpacing'      => (bool) $settings->linespacing,
                    'Justification'    => (bool) $settings->justification,
                    'Contrast'         => (bool) $settings->contrast,
                    'ImageReplacement' => (bool) $settings->image,
                ],
                // Plugin specific data
                'label'   => $settings->label,
                'class'   => $class,
                'parent'  => (int) $settings->position === Prepend::IN_TOP ? 'ul#top-info-user' : 'footer',
                'element' => (int) $settings->position === Prepend::IN_TOP ? 'li' : 'div',
            ];
            echo dcPage::jsJson('a11yc', $data);

            echo
            dcPage::cssModuleLoad(My::id() . '/lib/css/accessconfig.min.css', 'screen', $version) .
            dcPage::cssModuleLoad(My::id() . '/css/admin.css', 'screen', $version) .
            dcPage::jsModuleLoad(My::id() . '/js/admin.js', $version) .
            dcPage::jsModuleLoad(My::id() . '/lib/js/accessconfig.min.js', $version);
        }
    }

    public static function adminBeforeUserOptionsUpdate()
    {
        // Get and store user's prefs for plugin options
        try {
            $settings = dcCore::app()->auth->user_prefs->a11yConfig;

            $settings->put('active', !empty($_POST['a11yc_active']), 'boolean');

            $settings->put('label', Html::escapeHTML($_POST['a11yc_label']), 'string');
            $settings->put('icon', abs((int) $_POST['a11yc_icon']), 'integer');
            $settings->put('position', abs((int) $_POST['a11yc_position']), 'integer');

            $settings->put('font', !empty($_POST['a11yc_font']), 'boolean');
            $settings->put('linespacing', !empty($_POST['a11yc_linespacing']), 'boolean');
            $settings->put('justification', !empty($_POST['a11yc_justification']), 'boolean');
            $settings->put('contrast', !empty($_POST['a11yc_contrast']), 'boolean');
            $settings->put('image', !empty($_POST['a11yc_image']), 'boolean');
        } catch (Exception $e) {
            dcCore::app()->error->add($e->getMessage());
        }
    }

    public static function adminPreferencesForm()
    {
        $a11yc_positions = [
            Prepend::IN_TOP    => __('In admin header'),
            Prepend::IN_BOTTOM => __('In admin footer'),
        ];

        $a11yc_icons = [
            Prepend::ICON_NONE             => __('No'),
            Prepend::ICON_WHEELCHAIR       => __('Wheelchair'),
            Prepend::ICON_VISUALDEFICIENCY => __('Visual deficiency'),
        ];

        // Get user's prefs for plugin options
        $settings = dcCore::app()->auth->user_prefs->a11yConfig;

        $a11yc_active = (bool) $settings->active;

        $a11yc_label    = $settings->label;
        $a11yc_icon     = (int) $settings->icon;
        $a11yc_position = (int) $settings->position;

        $a11yc_font          = (bool) $settings->font;
        $a11yc_linespacing   = (bool) $settings->linespacing;
        $a11yc_justification = (bool) $settings->justification;
        $a11yc_contrast      = (bool) $settings->contrast;
        $a11yc_image         = (bool) $settings->image;

        echo
        '<div class="fieldset" id="a11yConfig"><h5>' . __('a11yConfig') . '</h5>';

        echo
        '<p>' . form::checkbox('a11yc_active', 1, $a11yc_active) . ' ' .
        '<label for="a11yc_active" class="classic">' . __('Activate a11yConfig in admin') . '</label></p>';

        echo
        '<p><label for="a11yc_label" class="required" title="' . __('Required field') . '"><abbr title="' . __('Required field') . '">*</abbr> ' . __('Label:') . '</label> ' .
        form::field('a11yc_label', 30, 256, Html::escapeHTML($a11yc_label), '', '', false, 'required placeholder="' . __('Accessibility parameters') . '"') .
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
