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
use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Form;
use Dotclear\Helper\Html\Form\Input;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Radio;
use Dotclear\Helper\Html\Form\Submit;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Html;
use Dotclear\Helper\Network\Http;
use Exception;

class Manage extends dcNsProcess
{
    /**
     * Initializes the page.
     */
    public static function init(): bool
    {
        static::$init = My::checkContext(My::MANAGE);

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
                $settings = dcCore::app()->blog->settings->get(My::id());

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
        $settings = dcCore::app()->blog->settings->get(My::id());

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

        $icons = [];
        $i     = 0;
        foreach ($a11yc_icons as $k => $v) {
            $icons[] = (new Radio(['a11yc_icon', 'a11yc_icon_' . $i], $a11yc_icon == $k))
                ->label((new Label($v, Label::INSIDE_TEXT_AFTER)));
            $i++;
        }

        $positions = [];
        $i         = 0;
        foreach ($a11yc_positions as $k => $v) {
            $positions[] = (new Radio(['a11yc_position', 'a11yc_position_' . $i], $a11yc_position == $k))
                ->label((new Label($v, Label::INSIDE_TEXT_AFTER)));
            $i++;
        }

        $head = dcPage::jsModuleLoad(My::id() . '/js/settings.js', dcCore::app()->getVersion(My::id()));

        dcPage::openModule(__('a11yConfig'), $head);

        echo dcPage::breadcrumb(
            [
                Html::escapeHTML(dcCore::app()->blog->name) => '',
                __('a11yConfig')                            => '',
            ]
        );
        echo dcPage::notices();

        // Form
        echo
        (new Form('a11y_params'))
            ->action(dcCore::app()->admin->getPageURL())
            ->method('post')
            ->fields([
                (new Para())->items([
                    (new Checkbox('a11yc_active', $a11yc_active))
                        ->value(1)
                        ->label((new Label(__('Activate a11yConfig on blog'), Label::INSIDE_TEXT_AFTER))),
                ]),
                (new Para())->class('form-note')->items([
                    (new Text(null, sprintf(__('A widget is available (see <a href="%s">%s</a>)'), dcCore::app()->adminurl->get('admin.plugin.widgets'), __('Presentation widgets')))),
                ]),
                (new Para())->items([
                    (new Input('a11yc_label'))
                        ->size(30)
                        ->maxlength(256)
                        ->value(Html::escapeHTML($a11yc_label))
                        ->required(true)
                        ->placeholder(__('Accessibility parameters'))
                        ->label((new Label(
                            (new Text('abbr', '*'))->title(__('Required field'))->render() . __('Label:'),
                            Label::INSIDE_TEXT_BEFORE
                        ))->id('a11yc_label_label')->class('required')->title(__('Required field'))),
                ]),
                // Options for button appearance
                (new Text('h3', __('Icon:'))),
                (new Para())->class('form-note')->items([
                    (new Text(null, __('The previous label will be used as alternative text if one of proposed icons is choosen.'))),
                ]),
                (new Para())->items($icons),
                // Options for automatic insertion
                (new Text('h3', __('Position:'))),
                (new Para())->items([
                    (new Checkbox('a11yc_injection', $a11yc_injection))
                        ->value(1)
                        ->label((new Label(__('Automatic insertion'), Label::INSIDE_TEXT_AFTER))),
                ]),
                (new Para())->class('form-note')->items([
                    (new Text(null, __('The automatic insertion in header depends on the <strong>publicTopAfterContent</strong> behavior and in footer on <strong>publicFooterContent</strong> behavior. Adapt theme\'s template files if necessary.'))),
                ]),
                (new Para())->items($positions),
                // Options
                (new Text('h3', __('Options:'))),
                (new Para())->items([
                    (new Checkbox('a11yc_font', $a11yc_font))
                        ->value(1)
                        ->label((new Label(__('Font adaptation'), Label::INSIDE_TEXT_AFTER))),
                    (new Checkbox('a11yc_linespacing', $a11yc_linespacing))
                        ->value(1)
                        ->label((new Label(__('Line Spacing adaptation'), Label::INSIDE_TEXT_AFTER))),
                    (new Checkbox('a11yc_justification', $a11yc_justification))
                        ->value(1)
                        ->label((new Label(__('Justification adaptation'), Label::INSIDE_TEXT_AFTER))),
                    (new Checkbox('a11yc_contrast', $a11yc_contrast))
                        ->value(1)
                        ->label((new Label(__('Contrast adaptation'), Label::INSIDE_TEXT_AFTER))),
                    (new Checkbox('a11yc_image', $a11yc_image))
                        ->value(1)
                        ->label((new Label(__('Image replacement'), Label::INSIDE_TEXT_AFTER))),
                ]),
                // Submit
                (new Para())->items([
                    (new Submit(['frmsubmit']))
                        ->value(__('Check')),
                    dcCore::app()->formNonce(false),
                ]),
            ])
        ->render();

        dcPage::closeModule();
    }
}
