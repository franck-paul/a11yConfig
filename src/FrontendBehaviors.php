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

class Frontendbehaviors
{
    public static function publicHeadContent()
    {
        if (!(bool) dcCore::app()->blog->settings->a11yConfig->active) {
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
        if (!(bool) dcCore::app()->blog->settings->a11yConfig->active) {
            return;
        }

        if (!(bool) dcCore::app()->blog->settings->a11yConfig->injection) {
            return;
        }

        if ((int) dcCore::app()->blog->settings->a11yConfig->position !== $position) {
            return;
        }

        $params = [
            'Font'             => (bool) dcCore::app()->blog->settings->a11yConfig->font,
            'LineSpacing'      => (bool) dcCore::app()->blog->settings->a11yConfig->linespacing,
            'Justification'    => (bool) dcCore::app()->blog->settings->a11yConfig->justification,
            'Contrast'         => (bool) dcCore::app()->blog->settings->a11yConfig->contrast,
            'ImageReplacement' => (bool) dcCore::app()->blog->settings->a11yConfig->image,
        ];

        echo FrontendHelper::render(dcCore::app()->blog->settings->a11yConfig->label, dcCore::app()->blog->settings->a11yConfig->icon, $params);
    }

    # Widget function
    public static function a11yconfigWidget($w)
    {
        if (!(bool) dcCore::app()->blog->settings->a11yConfig->active) {
            return;
        }

        if ($w->offline) {
            return;
        }

        $params = [
            'Font'             => ($w->font ? true : false),
            'LineSpacing'      => ($w->linespacing ? true : false),
            'Justification'    => ($w->justification ? true : false),
            'Contrast'         => ($w->contrast ? true : false),
            'ImageReplacement' => ($w->image ? true : false),
        ];

        return FrontendHelper::render($w->buttonname, $w->icon, $params, 'widget');
    }
}
