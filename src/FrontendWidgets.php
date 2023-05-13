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

class FrontendWidgets
{
    public static function renderWidget($w)
    {
        $settings = dcCore::app()->blog->settings->get(My::id());
        if (!(bool) $settings->active) {
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
