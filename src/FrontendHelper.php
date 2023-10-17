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
    /**
     * Render function
     *
     * @param      null|string              $label   The label
     * @param      int                      $icon    The icon
     * @param      array<string, mixed>     $params  The parameters
     * @param      string                   $class   The class
     *
     * @return     string
     */
    public static function render(?string $label, int $icon, array $params, string $class = ''): string
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

        $class .= match ($icon) {
            Prepend::ICON_WHEELCHAIR       => ($class !== '' ? ' ' : '') . 'a11yc-wc',
            Prepend::ICON_VISUALDEFICIENCY => ($class !== '' ? ' ' : '') . 'a11yc-vd',
            default                        => '',
        };

        return
        '<div ' . ($class !== '' ? 'class="' . $class . '" ' : '') . 'id="accessconfig" data-accessconfig-buttonname="' .
        ($label ? Html::escapeHTML($label) : __('Accessibility parameters')) . '" ' .
        'data-accessconfig-params=\'' . json_encode($options, JSON_THROW_ON_ERROR) . '\'>' .
        '</div>';
    }
}
