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

use Dotclear\App;
use Dotclear\Core\Backend\Notices;
use Dotclear\Core\Backend\Page;
use Dotclear\Core\Process;
use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Form;
use Dotclear\Helper\Html\Form\Input;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Radio;
use Dotclear\Helper\Html\Form\Submit;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Html;
use Exception;

class Manage extends Process
{
    /**
     * Initializes the page.
     */
    public static function init(): bool
    {
        return self::status(My::checkContext(My::MANAGE));
    }

    /**
     * Processes the request(s).
     */
    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        if ($_POST !== []) {
            try {
                $settings = My::settings();

                $settings->put('active', !empty($_POST['a11yc_active']), App::blogWorkspace()::NS_BOOL);

                $settings->put('injection', !empty($_POST['a11yc_injection']), App::blogWorkspace()::NS_BOOL);
                $settings->put('label', Html::escapeHTML($_POST['a11yc_label']), App::blogWorkspace()::NS_STRING);
                $settings->put('icon', abs((int) $_POST['a11yc_icon']), App::blogWorkspace()::NS_INT);
                $settings->put('position', abs((int) $_POST['a11yc_position']), App::blogWorkspace()::NS_INT);

                $settings->put('font', !empty($_POST['a11yc_font']), App::blogWorkspace()::NS_BOOL);
                $settings->put('linespacing', !empty($_POST['a11yc_linespacing']), App::blogWorkspace()::NS_BOOL);
                $settings->put('justification', !empty($_POST['a11yc_justification']), App::blogWorkspace()::NS_BOOL);
                $settings->put('contrast', !empty($_POST['a11yc_contrast']), App::blogWorkspace()::NS_BOOL);
                $settings->put('image', !empty($_POST['a11yc_image']), App::blogWorkspace()::NS_BOOL);

                App::blog()->triggerBlog();

                Notices::addSuccessNotice(__('Settings have been successfully updated.'));
                My::redirect();
            } catch (Exception $e) {
                App::error()->add($e->getMessage());
            }
        }

        return true;
    }

    /**
     * Renders the page.
     */
    public static function render(): void
    {
        if (!self::status()) {
            return;
        }

        // Get current options
        $settings = My::settings();

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
                ->value($k)
                ->label((new Label($v, Label::INSIDE_TEXT_AFTER)));
            ++$i;
        }

        $positions = [];
        $i         = 0;
        foreach ($a11yc_positions as $k => $v) {
            $positions[] = (new Radio(['a11yc_position', 'a11yc_position_' . $i], $a11yc_position == $k))
                ->value($k)
                ->label((new Label($v, Label::INSIDE_TEXT_AFTER)));
            ++$i;
        }

        $head = My::jsLoad('settings.js');

        Page::openModule(My::name(), $head);

        echo Page::breadcrumb(
            [
                Html::escapeHTML(App::blog()->name()) => '',
                __('a11yConfig')                      => '',
            ]
        );
        echo Notices::getNotices();

        // Form
        echo
        (new Form('a11y_params'))
            ->action(App::backend()->getPageURL())
            ->method('post')
            ->fields([
                (new Para())->items([
                    (new Checkbox('a11yc_active', $a11yc_active))
                        ->value(1)
                        ->label((new Label(__('Activate a11yConfig on blog'), Label::INSIDE_TEXT_AFTER))),
                ]),
                (new Para())->class('form-note')->items([
                    (new Text(null, sprintf(__('A widget is available (see <a href="%s">%s</a>)'), App::backend()->url()->get('admin.plugin.widgets'), __('Presentation widgets')))),
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
                    ... My::hiddenFields(),
                ]),
            ])
        ->render();

        Page::closeModule();
    }
}
