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

use ArrayObject;

class FrontendTemplate
{
    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     */
    public static function tplAccessConfig(array|ArrayObject $attr): string
    {
        $settings = My::settings();
        if (!(bool) $settings->active) {
            return '';
        }

        $title = $attr['title'] ?? null;
        $icon  = isset($attr['icon']) ? (int) $attr['icon'] : Prepend::ICON_NONE;

        $params = [
            'Font'             => isset($attr['font']) ? (bool) $attr['font'] : true,
            'LineSpacing'      => isset($attr['linespacing']) ? (bool) $attr['linespacing'] : true,
            'Justification'    => isset($attr['justification']) ? (bool) $attr['justification'] : true,
            'Contrast'         => isset($attr['contrast']) ? (bool) $attr['contrast'] : true,
            'ImageReplacement' => isset($attr['image']) ? (bool) $attr['image'] : true,
        ];

        return '<?= "' . addcslashes(FrontendHelper::render($title, $icon, $params), '"\\') . '" ?>';
    }
}
