<?php

/**
 * @brief a11yConfig, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul, Biou and contributors
 *
 * @copyright Franck Paul contact@open-time.net
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\a11yConfig;

use Dotclear\App;
use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Form;
use Dotclear\Helper\Html\Form\Input;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Note;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Radio;
use Dotclear\Helper\Html\Form\Span;
use Dotclear\Helper\Html\Form\Submit;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Html;
use Dotclear\Helper\Process\TraitProcess;
use Exception;

class Manage
{
    use TraitProcess;

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
            // Post data helpers
            $_Bool = fn (string $name): bool => !empty($_POST[$name]);
            $_Int  = fn (string $name, int $default = 0): int => isset($_POST[$name]) && is_numeric($val = $_POST[$name]) ? (int) $val : $default;
            $_Str  = fn (string $name, string $default = ''): string => isset($_POST[$name]) && is_string($val = $_POST[$name]) ? $val : $default;

            try {
                $settings = My::settings();

                $settings->put('active', $_Bool('a11yc_active'), App::blogWorkspace()::NS_BOOL);

                $settings->put('injection', $_Bool('a11yc_injection'), App::blogWorkspace()::NS_BOOL);
                $settings->put('label', Html::escapeHTML($_Str('a11yc_label')), App::blogWorkspace()::NS_STRING);
                $settings->put('icon', abs($_Int('a11yc_icon')), App::blogWorkspace()::NS_INT);
                $settings->put('position', abs($_Int('a11yc_position')), App::blogWorkspace()::NS_INT);

                $settings->put('font', $_Bool('a11yc_font'), App::blogWorkspace()::NS_BOOL);
                $settings->put('linespacing', $_Bool('a11yc_linespacing'), App::blogWorkspace()::NS_BOOL);
                $settings->put('justification', $_Bool('a11yc_justification'), App::blogWorkspace()::NS_BOOL);
                $settings->put('contrast', $_Bool('a11yc_contrast'), App::blogWorkspace()::NS_BOOL);
                $settings->put('image', $_Bool('a11yc_image'), App::blogWorkspace()::NS_BOOL);

                App::blog()->triggerBlog();

                App::backend()->notices()->addSuccessNotice(__('Settings have been successfully updated.'));
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

        // Variable data helpers
        $_Bool = fn (mixed $var): bool => (bool) $var;
        $_Int  = fn (mixed $var, int $default = 0): int => $var !== null && is_numeric($val = $var) ? (int) $val : $default;
        $_Str  = fn (mixed $var, string $default = ''): string => $var !== null && is_string($val = $var) ? $val : $default;

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

        $a11yc_active = $_Bool($settings->active);

        $a11yc_injection     = $_Bool($settings->injection);
        $a11yc_label         = $_Str($settings->label);
        $a11yc_icon          = $_Int($settings->icon);
        $a11yc_position      = $_Int($settings->position);
        $a11yc_font          = $_Bool($settings->font);
        $a11yc_linespacing   = $_Bool($settings->linespacing);
        $a11yc_justification = $_Bool($settings->justification);
        $a11yc_contrast      = $_Bool($settings->contrast);
        $a11yc_image         = $_Bool($settings->image);

        $icons = [];
        $i     = 0;
        foreach ($a11yc_icons as $k => $v) {
            $icons[] = (new Radio(['a11yc_icon', 'a11yc_icon_' . $i], $a11yc_icon === $k))
                ->value($k)
                ->label((new Label($v, Label::INSIDE_TEXT_AFTER)));
            ++$i;
        }

        $positions = [];
        $i         = 0;
        foreach ($a11yc_positions as $k => $v) {
            $positions[] = (new Radio(['a11yc_position', 'a11yc_position_' . $i], $a11yc_position === $k))
                ->value($k)
                ->label((new Label($v, Label::INSIDE_TEXT_AFTER)));
            ++$i;
        }

        $head = My::jsLoad('settings.js');

        App::backend()->page()->openModule(My::name(), $head);

        echo App::backend()->page()->breadcrumb(
            [
                Html::escapeHTML(App::blog()->name()) => '',
                __('a11yConfig')                      => '',
            ]
        );
        echo App::backend()->notices()->getNotices();

        // Form
        echo
        (new Form('a11y_params'))
            ->action(App::backend()->getPageURL())
            ->method('post')
            ->fields([
                (new Note())
                    ->class('form-note')
                    ->text(sprintf(__('Fields preceded by %s are mandatory.'), (new Span('*'))->class('required')->render())),
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
                        ->label(
                            (new Label(
                                (new Span('*'))->render() . __('Label:'),
                                Label::INSIDE_TEXT_BEFORE
                            ))
                        )
                        ->title(__('Required field')),
                ]),
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
                // Options for button appearance
                (new Text('h3', __('Icon:'))),
                (new Para())->class('form-note')->items([
                    (new Text(null, __('The previous label will be used as alternative text if one of proposed icons is choosen.'))),
                ]),
                (new Para())->items($icons),
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
                        ->value(__('Save')),
                    ... My::hiddenFields(),
                ]),
            ])
        ->render();

        App::backend()->page()->closeModule();
    }
}
