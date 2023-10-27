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

use Dotclear\Plugin\widgets\WidgetsElement;

class FrontendWidgets
{
    public static function renderWidget(WidgetsElement $w): string
    {
        $settings = My::settings();
        if (!(bool) $settings->active) {
            return '';
        }

        if ($w->offline) {
            return '';
        }

        $params = [
            'Font'             => ((bool) $w->get('font')),
            'LineSpacing'      => ((bool) $w->get('linespacing')),
            'Justification'    => ((bool) $w->get('justification')),
            'Contrast'         => ((bool) $w->get('contrast')),
            'ImageReplacement' => ((bool) $w->get('image')),
        ];

        return FrontendHelper::render($w->get('buttonname'), (int) $w->get('icon'), $params, 'widget');
    }
}
