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

use Dotclear\Plugin\widgets\WidgetsElement;

class FrontendWidgets
{
    public static function renderWidget(WidgetsElement $widgetsElement): string
    {
        $settings = My::settings();
        if (!$settings->getBool('active', false)) {
            return '';
        }

        if ($widgetsElement->offline) {
            return '';
        }

        $params = [
            'Font'             => ((bool) $widgetsElement->get('font')),
            'LineSpacing'      => ((bool) $widgetsElement->get('linespacing')),
            'Justification'    => ((bool) $widgetsElement->get('justification')),
            'Contrast'         => ((bool) $widgetsElement->get('contrast')),
            'ImageReplacement' => ((bool) $widgetsElement->get('image')),
        ];

        $name = is_string($name = $widgetsElement->get('buttonname')) ? $name : null;
        $icon = is_numeric($icon = $widgetsElement->get('icon')) ? (int) $icon : 0;

        return FrontendHelper::render($name, $icon, $params, 'widget');
    }
}
