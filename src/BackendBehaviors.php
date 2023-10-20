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
use Dotclear\Core\Backend\Page;
use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Input;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Radio;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Html;
use Exception;

class BackendBehaviors
{
    public static function adminPageHTMLHead(): string
    {
        $preferences = My::prefs();

        if ($preferences?->active) {
            $class = match ((int) $preferences->icon) {
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
                'label'   => $preferences->label,
                'class'   => $class,
                'parent'  => (int) $preferences->position === Prepend::IN_TOP ? 'ul#top-info-user' : 'footer',
                'element' => (int) $preferences->position === Prepend::IN_TOP ? 'li' : 'div',
            ];
            echo Page::jsJson('a11yc', $data);

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
        // Get and store user's prefs for plugin options
        try {
            $preferences = My::prefs();

            if ($preferences) {
                $preferences->put('active', !empty($_POST['a11yc_active']), App::userWorkspace()::WS_BOOL);

                $preferences->put('label', Html::escapeHTML($_POST['a11yc_label']), App::userWorkspace()::WS_STRING);
                $preferences->put('icon', abs((int) $_POST['a11yc_icon']), App::userWorkspace()::WS_INT);
                $preferences->put('position', abs((int) $_POST['a11yc_position']), App::userWorkspace()::WS_INT);

                $preferences->put('font', !empty($_POST['a11yc_font']), App::userWorkspace()::WS_BOOL);
                $preferences->put('linespacing', !empty($_POST['a11yc_linespacing']), App::userWorkspace()::WS_BOOL);
                $preferences->put('justification', !empty($_POST['a11yc_justification']), App::userWorkspace()::WS_BOOL);
                $preferences->put('contrast', !empty($_POST['a11yc_contrast']), App::userWorkspace()::WS_BOOL);
                $preferences->put('image', !empty($_POST['a11yc_image']), App::userWorkspace()::WS_BOOL);
            }
        } catch (Exception $e) {
            App::error()->add($e->getMessage());
        }

        return '';
    }

    public static function adminPreferencesHeaders(): string
    {
        return My::jsLoad('settings.js');
    }

    public static function adminPreferencesForm(): string
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
        $preferences = My::prefs();

        $a11yc_active = (bool) $preferences?->active;

        $a11yc_label    = $preferences?->label;
        $a11yc_icon     = (int) $preferences?->icon;
        $a11yc_position = (int) $preferences?->position;

        $a11yc_font          = (bool) $preferences?->font;
        $a11yc_linespacing   = (bool) $preferences?->linespacing;
        $a11yc_justification = (bool) $preferences?->justification;
        $a11yc_contrast      = (bool) $preferences?->contrast;
        $a11yc_image         = (bool) $preferences?->image;

        $icons = [];
        $i     = 0;
        foreach ($a11yc_icons as $k => $v) {
            $icons[] = (new Radio(['a11yc_icon', 'a11yc_icon_' . $i], $a11yc_icon == $k))
                ->value($k)
                ->label((new Label($v, Label::INSIDE_TEXT_AFTER)));
            $i++;
        }

        $positions = [];
        $i         = 0;
        foreach ($a11yc_positions as $k => $v) {
            $positions[] = (new Radio(['a11yc_position', 'a11yc_position_' . $i], $a11yc_position == $k))
                ->value($k)
                ->label((new Label($v, Label::INSIDE_TEXT_AFTER)));
            $i++;
        }

        echo
        (new Fieldset('a11yConfig'))
        ->legend((new Legend(__('a11yConfig'))))
        ->fields([
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
                    ->label((new Label(
                        (new Text('abbr', '*'))->title(__('Required field'))->render() . __('Label:'),
                        Label::INSIDE_TEXT_BEFORE
                    ))->id('a11yc_label_label')->class('required')->title(__('Required field'))),
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
