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
require_once __DIR__ . '/_widgets.php';

class a11yconfigPublic
{
    public static function publicHeadContent()
    {
        if (!(bool) dcCore::app()->blog->settings->a11yConfig->active) {
            return;
        }

        echo
        dcUtils::cssModuleLoad('a11yConfig/lib/css/accessconfig.min.css') .
        dcUtils::cssModuleLoad('a11yConfig/css/public.css') .
        dcUtils::jsModuleLoad('a11yConfig/js/public.js') .
        dcUtils::jsModuleLoad('a11yConfig/lib/js/accessconfig.min.js');
    }

    public static function publicTopAfterContent()
    {
        self::inject(a11yconfigConst::IN_TOP);
    }

    public static function publicFooterContent()
    {
        self::inject(a11yconfigConst::IN_BOTTOM);
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

        echo self::render(dcCore::app()->blog->settings->a11yConfig->label, dcCore::app()->blog->settings->a11yConfig->icon, $params);
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

        return self::render($w->buttonname, $w->icon, $params, 'widget');
    }

    # Template function
    public static function tplAccessConfig($attr)
    {
        if (!(bool) dcCore::app()->blog->settings->a11yConfig->active) {
            return;
        }

        $title = $attr['title'] ?? null;
        $icon  = isset($attr['icon']) ? (int) $attr['icon'] : a11yconfigConst::ICON_NONE;

        $params = [
            'Font'             => isset($attr['font']) ? (bool) $attr['font'] : true,
            'LineSpacing'      => isset($attr['linespacing']) ? (bool) $attr['linespacing'] : true,
            'Justification'    => isset($attr['justification']) ? (bool) $attr['justification'] : true,
            'Contrast'         => isset($attr['contrast']) ? (bool) $attr['contrast'] : true,
            'ImageReplacement' => isset($attr['image']) ? (bool) $attr['image'] : true,
        ];

        return '<?php echo "' . addcslashes(self::render($title, $icon, $params), '"\\') . '"; ?>';
    }

    # Render function
    private static function render($label, $icon, $params, $class = '')
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
            case a11yconfigConst::ICON_WHEELCHAIR:
                $class .= ($class !== '' ? ' ' : '') . 'a11yc-wc';

                break;
            case a11yconfigConst::ICON_VISUALDEFICIENCY:
                $class .= ($class !== '' ? ' ' : '') . 'a11yc-vd';

                break;
        }

        return
        '<div ' . ($class !== '' ? 'class="' . $class . '" ' : '') . 'id="accessconfig" data-accessconfig-buttonname="' .
        ($label ? html::escapeHTML($label) : __('Accessibility parameters')) . '" ' .
        'data-accessconfig-params=\'' . json_encode($options, JSON_THROW_ON_ERROR) . '\'>' .
            '</div>';
    }
}

dcCore::app()->addBehaviors([
    'publicHeadContent'     => [a11yconfigPublic::class, 'publicHeadContent'],
    'publicTopAfterContent' => [a11yconfigPublic::class, 'publicTopAfterContent'],
    'publicFooterContent'   => [a11yconfigPublic::class, 'publicFooterContent'],
]);

dcCore::app()->tpl->addValue('AccessConfig', [a11yconfigPublic::class, 'tplAccessConfig']);
