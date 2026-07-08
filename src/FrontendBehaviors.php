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
        if (!$settings->getBool('active', false)) {
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
        if (!$settings->getBool('active', false)) {
            return;
        }

        if (!$settings->getBool('injection', false)) {
            return;
        }

        $settings_position = $settings->getInt('position', false);
        if ($settings_position !== $position) {
            return;
        }

        $label = $settings->getStr('label');
        $icon  = $settings->getInt('icon', false);

        $params = [
            'Font'             => $settings->getBool('font', false),
            'LineSpacing'      => $settings->getBool('linespacing', false),
            'Justification'    => $settings->getBool('justification', false),
            'Contrast'         => $settings->getBool('contrast', false),
            'ImageReplacement' => $settings->getBool('image', false),
        ];

        echo FrontendHelper::render($label, $icon, $params);
    }
}
