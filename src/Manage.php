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
use dcPage;
use Dotclear\Helper\Html\Html;
use Dotclear\Helper\Network\Http;
use Exception;
use form;

class Manage extends dcNsProcess
{
    /**
     * Initializes the page.
     */
    public static function init(): bool
    {
        // Manageable only by super-admin
        static::$init = defined('DC_CONTEXT_ADMIN')
            && dcCore::app()->auth->isSuperAdmin()
            && My::phpCompliant();

        return static::$init;
    }

    /**
     * Processes the request(s).
     */
    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        if (!empty($_POST)) {
            try {
                $settings = dcCore::app()->blog->settings->a11yConfig;

                $settings->put('active', !empty($_POST['a11yc_active']));

                $settings->put('injection', !empty($_POST['a11yc_injection']));
                $settings->put('label', Html::escapeHTML($_POST['a11yc_label']));
                $settings->put('icon', abs((int) $_POST['a11yc_icon']));
                $settings->put('position', abs((int) $_POST['a11yc_position']));

                $settings->put('font', !empty($_POST['a11yc_font']));
                $settings->put('linespacing', !empty($_POST['a11yc_linespacing']));
                $settings->put('justification', !empty($_POST['a11yc_justification']));
                $settings->put('contrast', !empty($_POST['a11yc_contrast']));
                $settings->put('image', !empty($_POST['a11yc_image']));

                dcCore::app()->blog->triggerBlog();

                dcPage::addSuccessNotice(__('Settings have been successfully updated.'));
                Http::redirect(dcCore::app()->admin->getPageURL());
            } catch (Exception $e) {
                dcCore::app()->error->add($e->getMessage());
            }
        }

        return true;
    }

    /**
     * Renders the page.
     */
    public static function render(): void
    {
        if (!static::$init) {
            return;
        }

        // Get current options
        $settings = dcCore::app()->blog->settings->a11yConfig;

        $a11yc_positions = [
            Prepend::IN_TOP    => __('In header'),
            Prepend::IN_BOTTOM => __('In footer'),
        ];

        $a11yc_icons = [
            Prepend::ICON_NONE             => __('No'),
            Prepend::ICON_WHEELCHAIR       => __('Wheelchair'),
            Prepend::ICON_VISUALDEFICIENCY => __('Visual deficiency'),
        ];

        $a11yc_active = (bool) $settings->active;

        $a11yc_injection = (bool) $settings->injection;
        $a11yc_label     = $settings->label;
        $a11yc_icon      = (int) $settings->icon;
        $a11yc_position  = (int) $settings->position;

        $a11yc_font          = (bool) $settings->font;
        $a11yc_linespacing   = (bool) $settings->linespacing;
        $a11yc_justification = (bool) $settings->justification;
        $a11yc_contrast      = (bool) $settings->contrast;
        $a11yc_image         = (bool) $settings->image;

        dcPage::openModule(__('a11yConfig'));

        echo dcPage::breadcrumb(
            [
                Html::escapeHTML(dcCore::app()->blog->name) => '',
                __('a11yConfig')                            => '',
            ]
        );
        echo dcPage::notices();

        // Form
        echo
        '<form action="' . dcCore::app()->admin->getPageURL() . '" method="post">' .
        '<p>' . form::checkbox('a11yc_active', 1, $a11yc_active) . ' ' .
        '<label for="a11yc_active" class="classic">' . __('Activate a11yConfig on blog') . '</label></p>';

        echo
        '<p class="form-note">' . sprintf(__('A widget is available (see <a href="%s">%s</a>)'), dcCore::app()->adminurl->get('admin.plugin.widgets'), __('Presentation widgets')) . '</p>';

        echo
        '<h3>' . __('Automatic insertion') . '</h3>' .
        '<p>' . form::checkbox('a11yc_injection', 1, $a11yc_injection) . ' ' .
        '<label for="a11yc_injection" class="classic">' . __('Automatic insertion') . '</label></p>';

        echo
        '<p><label for="a11yc_label" class="required" title="' . __('Required field') . '"><abbr title="' . __('Required field') . '">*</abbr> ' . __('Label:') . '</label> ' .
        form::field('a11yc_label', 30, 256, Html::escapeHTML($a11yc_label), '', '', false, 'required placeholder="' . __('Accessibility parameters') . '"') .
            '</p>';

        // Options for button appearance
        echo '<h4>' . __('Icon:') . '</h4>';
        echo
        '<p class="form-note">' . __('The previous label will be used as alternative text if one of proposed icons is choosen.') . '</p>';
        $i = 0;
        foreach ($a11yc_icons as $k => $v) {
            echo '<p><label for="a11yc_icon_' . $i . '" class="classic">' .
            form::radio(['a11yc_icon', 'a11yc_icon_' . $i], $k, $a11yc_icon == $k) . ' ' . $v . '</label></p>';
            $i++;
        }

        // Options for automatic insertion
        echo '<h4>' . __('Position:') . '</h4>';
        echo
        '<p class="form-note">' . __('The automatic insertion in header depends on the <strong>publicTopAfterContent</strong> behavior and in footer on <strong>publicFooterContent</strong> behavior. Adapt theme\'s template files if necessary.') . '</p>';
        $i = 0;
        foreach ($a11yc_positions as $k => $v) {
            echo '<p><label for="a11yc_position_' . $i . '" class="classic">' .
            form::radio(['a11yc_position', 'a11yc_position_' . $i], $k, $a11yc_position == $k) . ' ' . $v . '</label></p>';
            $i++;
        }

        echo '<h4>' . __('Options:') . '</h4>';
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
        '<p>' . dcCore::app()->formNonce() . '<input type="submit" value="' . __('Save') . '" /></p>' . '</form>';

        dcPage::closeModule();
    }
}
