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

use Dotclear\Helper\Html\Html;

class FrontendHelper
{
    # Render function
    public static function render($label, $icon, $params, $class = '')
    {
        $options = [
            'Prefix'           => 'a42-ac',
            'Modal'            => true,
            'Font'             => true,
            'LineSpacing'      => true,
            'Justification'    => true,
            'Contrast'         => true,
            'ImageReplacement' => true,
        ];
        $options = array_merge($options, $params);

        switch ($icon) {
            case Prepend::ICON_WHEELCHAIR:
                $class .= ($class !== '' ? ' ' : '') . 'a11yc-wc';

                break;
            case Prepend::ICON_VISUALDEFICIENCY:
                $class .= ($class !== '' ? ' ' : '') . 'a11yc-vd';

                break;
        }

        return
        '<div ' . ($class !== '' ? 'class="' . $class . '" ' : '') . 'id="accessconfig" data-accessconfig-buttonname="' .
        ($label ? Html::escapeHTML($label) : __('Accessibility parameters')) . '" ' .
        'data-accessconfig-params=\'' . json_encode($options, JSON_THROW_ON_ERROR) . '\'>' .
            '</div>';
    }
}
