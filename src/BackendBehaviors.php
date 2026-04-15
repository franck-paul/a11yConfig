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
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Input;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Note;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Radio;
use Dotclear\Helper\Html\Form\Span;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Html;
use Exception;

class BackendBehaviors
{
    public static function adminPageHTMLHead(): string
    {
        $preferences = My::prefs();

        if ($preferences->active) {
            $icon     = is_numeric($icon = $preferences->icon) ? (int) $icon : 0;
            $label    = is_string($label = $preferences->label) ? $label : null;
            $position = is_numeric($position = $preferences->position) ? (int) $position : 0;

            $class = match ($icon) {
                Prepend::ICON_WHEELCHAIR       => 'a11yc-wc',
                Prepend::ICON_VISUALDEFICIENCY => 'a11yc-vd',
                default                        => '',
            };

            $data = [
                // AccessConfig Library data
                'options' => [
                    'Prefix'           => 'a42-ac',
                    'Modal'            => true,
                    'Font'             => (bool) $preferences->font,
                    'LineSpacing'      => (bool) $preferences->linespacing,
                    'Justification'    => (bool) $preferences->justification,
                    'Contrast'         => (bool) $preferences->contrast,
                    'ImageReplacement' => (bool) $preferences->image,
                ],
                // Plugin specific data
                'label'   => $label,
                'class'   => $class,
                'parent'  => $position === Prepend::IN_TOP ? 'ul#top-info-user' : 'footer',
                'element' => $position === Prepend::IN_TOP ? 'li' : 'div',
            ];
            echo App::backend()->page()->jsJson('a11yc', $data);

            echo
            My::cssLoad('/lib/css/accessconfig.min.css') .
            My::cssLoad('admin.css') .
            My::jsLoad('admin.js') .
            My::jsLoad('/lib/js/accessconfig.min.js');
        }

        return '';
    }

    public static function adminBeforeUserOptionsUpdate(): string
    {
        // Post data helpers
        $_Bool = fn (string $name): bool => !empty($_POST[$name]);
        $_Int  = fn (string $name, int $default = 0): int => isset($_POST[$name]) && is_numeric($val = $_POST[$name]) ? (int) $val : $default;
        $_Str  = fn (string $name, string $default = ''): string => isset($_POST[$name]) && is_string($val = $_POST[$name]) ? $val : $default;

        // Get and store user's prefs for plugin options
        try {
            $preferences = My::prefs();

            $preferences->put('active', $_Bool('a11yc_active'), App::userWorkspace()::WS_BOOL);

            $preferences->put('label', Html::escapeHTML($_Str('a11yc_label')), App::userWorkspace()::WS_STRING);
            $preferences->put('icon', abs($_Int('a11yc_icon')), App::userWorkspace()::WS_INT);
            $preferences->put('position', abs($_Int('a11yc_position')), App::userWorkspace()::WS_INT);

            $preferences->put('font', $_Bool('a11yc_font'), App::userWorkspace()::WS_BOOL);
            $preferences->put('linespacing', $_Bool('a11yc_linespacing'), App::userWorkspace()::WS_BOOL);
            $preferences->put('justification', $_Bool('a11yc_justification'), App::userWorkspace()::WS_BOOL);
            $preferences->put('contrast', $_Bool('a11yc_contrast'), App::userWorkspace()::WS_BOOL);
            $preferences->put('image', $_Bool('a11yc_image'), App::userWorkspace()::WS_BOOL);
        } catch (Exception $exception) {
            App::error()->add($exception->getMessage());
        }

        return '';
    }

    public static function adminPreferencesHeaders(): string
    {
        return My::jsLoad('settings.js');
    }

    public static function adminPreferencesForm(): string
    {
        // Variable data helpers
        $_Bool = fn (mixed $var): bool => (bool) $var;
        $_Int  = fn (mixed $var, int $default = 0): int => $var !== null && is_numeric($val = $var) ? (int) $val : $default;
        $_Str  = fn (mixed $var, string $default = ''): string => $var !== null && is_string($val = $var) ? $val : $default;

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
        $preferences = My::prefs();

        $a11yc_active = $_Bool($preferences->active);

        $a11yc_label    = $_Str($preferences->label);
        $a11yc_icon     = $_Int($preferences->icon);
        $a11yc_position = $_Int($preferences->position);

        $a11yc_font          = $_Bool($preferences->font);
        $a11yc_linespacing   = $_Bool($preferences->linespacing);
        $a11yc_justification = $_Bool($preferences->justification);
        $a11yc_contrast      = $_Bool($preferences->contrast);
        $a11yc_image         = $_Bool($preferences->image);

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

        echo
        (new Fieldset('a11yConfig'))
        ->legend((new Legend(__('a11yConfig'))))
        ->fields([
            (new Note())
                ->class('form-note')
                ->text(sprintf(__('Fields preceded by %s are mandatory.'), (new Span('*'))->class('required')->render())),
            (new Para())->items([
                (new Checkbox('a11yc_active', $a11yc_active))
                    ->value(1)
                    ->label((new Label(__('Activate a11yConfig in admin'), Label::INSIDE_TEXT_AFTER))),
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
            // Options for button appearance
            (new Text('h5', __('Icon:'))),
            (new Para())->class('form-note')->items([
                (new Text(null, __('The previous label will be used as alternative text if one of proposed icons is choosen.'))),
            ]),
            (new Para())->items($icons),
            // Options for automatic insertion
            (new Text('h5', __('Position:'))),
            (new Para())->items($positions),
            // Options
            (new Text('h5', __('Options:'))),
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
        ])
        ->render();

        return '';
    }
}
