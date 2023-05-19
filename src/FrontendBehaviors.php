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
use dcUtils;

class FrontendBehaviors
{
    public static function publicHeadContent()
    {
        $settings = dcCore::app()->blog->settings->get(My::id());
        if (!(bool) $settings->active) {
            return;
        }

        echo
        dcUtils::cssModuleLoad(My::id() . '/lib/css/accessconfig.min.css') .
        dcUtils::cssModuleLoad(My::id() . '/css/public.css') .
        dcUtils::jsModuleLoad(My::id() . '/js/public.js') .
        dcUtils::jsModuleLoad(My::id() . '/lib/js/accessconfig.min.js');
    }

    public static function publicTopAfterContent()
    {
        self::inject(Prepend::IN_TOP);
    }

    public static function publicFooterContent()
    {
        self::inject(Prepend::IN_BOTTOM);
    }

    private static function inject($position)
    {
        $settings = dcCore::app()->blog->settings->get(My::id());
        if (!(bool) $settings->active) {
            return;
        }

        if (!(bool) $settings->injection) {
            return;
        }

        if ((int) $settings->position !== $position) {
            return;
        }

        $params = [
            'Font'             => (bool) $settings->font,
            'LineSpacing'      => (bool) $settings->linespacing,
            'Justification'    => (bool) $settings->justification,
            'Contrast'         => (bool) $settings->contrast,
            'ImageReplacement' => (bool) $settings->image,
        ];

        echo FrontendHelper::render($settings->label, $settings->icon, $params);
    }
}
