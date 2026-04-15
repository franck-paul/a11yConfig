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

class FrontendBehaviors
{
    public static function publicHeadContent(): string
    {
        $settings = My::settings();
        if (!(bool) $settings->active) {
            return '';
        }

        echo
        My::cssLoad('/lib/css/accessconfig.min.css') .
        My::cssLoad('public.css') .
        My::jsLoad('public.js') .
        My::jsLoad('/lib/js/accessconfig.min.js');

        return '';
    }

    public static function publicTopAfterContent(): string
    {
        self::inject(Prepend::IN_TOP);

        return '';
    }

    public static function publicFooterContent(): string
    {
        self::inject(Prepend::IN_BOTTOM);

        return '';
    }

    private static function inject(int $position): void
    {
        $settings = My::settings();
        if (!(bool) $settings->active) {
            return;
        }

        if (!(bool) $settings->injection) {
            return;
        }

        $settings_position = is_numeric($settings_position = $settings->position) ? (int) $settings_position : 0;
        if ($settings_position !== $position) {
            return;
        }

        $label = is_string($label = $settings->label) ? $label : null;
        $icon  = is_numeric($icon = $settings->icon) ? (int) $icon : 0;

        $params = [
            'Font'             => (bool) $settings->font,
            'LineSpacing'      => (bool) $settings->linespacing,
            'Justification'    => (bool) $settings->justification,
            'Contrast'         => (bool) $settings->contrast,
            'ImageReplacement' => (bool) $settings->image,
        ];

        echo FrontendHelper::render($label, $icon, $params);
    }
}
