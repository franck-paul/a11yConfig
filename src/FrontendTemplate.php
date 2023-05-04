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

class FrontendTemplate
{
    # Template function
    public static function tplAccessConfig($attr)
    {
        if (!(bool) dcCore::app()->blog->settings->get(My::id())->active) {
            return;
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

        return '<?php echo "' . addcslashes(FrontendHelper::render($title, $icon, $params), '"\\') . '"; ?>';
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
