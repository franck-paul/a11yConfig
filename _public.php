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

if (!defined('DC_RC_PATH')) {return;}

require dirname(__FILE__) . '/_widgets.php';

$core->addBehavior('publicHeadContent', array('a11yconfigPublic', 'publicHeadContent'));
$core->addBehavior('publicTopAfterContent', array('a11yconfigPublic', 'publicTopAfterContent'));
$core->addBehavior('publicFooterContent', array('a11yconfigPublic', 'publicFooterContent'));

class a11yconfigPublic
{
    public static function publicHeadContent($core, $_ctx)
    {
        $core->blog->settings->addNamespace('a11yConfig');
        if (!(boolean) $core->blog->settings->a11yConfig->active) {
            return;
        }

        echo
        dcUtils::cssLoad($core->blog->getPF('a11yConfig/lib/css/accessconfig.min.css')) .
        dcUtils::cssLoad($core->blog->getPF('a11yConfig/css/public.css')) .
        dcUtils::jsLoad($core->blog->getPF('a11yConfig/js/public.js')) .
        dcUtils::jsLoad($core->blog->getPF('a11yConfig/lib/js/accessconfig.min.js'));
    }

    public static function publicTopAfterContent($core, $_ctx)
    {
        self::inject($core, 0);
    }

    public static function publicFooterContent($core, $_ctx)
    {
        self::inject($core, 1);
    }

    private static function inject($core, $position)
    {
        $core->blog->settings->addNamespace('a11yConfig');
        if (!(boolean) $core->blog->settings->a11yConfig->active) {
            return;
        }

        if (!(boolean) $core->blog->settings->a11yConfig->injection) {
            return;
        }

        if ((integer) $core->blog->settings->a11yConfig->position !== $position) {
            return;
        }

        $params = [
            "Font"             => (boolean) $core->blog->settings->a11yConfig->font,
            "LineSpacing"      => (boolean) $core->blog->settings->a11yConfig->linespacing,
            "Justification"    => (boolean) $core->blog->settings->a11yConfig->justification,
            "Contrast"         => (boolean) $core->blog->settings->a11yConfig->contrast,
            "ImageReplacement" => (boolean) $core->blog->settings->a11yConfig->image
        ];

        echo self::render($core->blog->settings->a11yConfig->label, $core->blog->settings->a11yConfig->icon, $params);
    }

    # Widget function
    public static function a11yconfigWidget($w)
    {
        global $core;

        $core->blog->settings->addNamespace('a11yConfig');
        if (!(boolean) $core->blog->settings->a11yConfig->active) {
            return;
        }

        if ($w->offline) {
            return;
        }

        $params = [
            "Font"             => ($w->font ? true : false),
            "LineSpacing"      => ($w->linespacing ? true : false),
            "Justification"    => ($w->justification ? true : false),
            "Contrast"         => ($w->contrast ? true : false),
            "ImageReplacement" => ($w->image ? true : false)
        ];

        return self::render($w->buttonname, $w->icon, $params, 'widget');
    }

    # Render function
    private static function render($label, $icon, $params, $class = '')
    {
        $options = [
            "Prefix"           => "a42-ac",
            "Modal"            => true,
            "Font"             => true,
            "LineSpacing"      => true,
            "Justification"    => true,
            "Contrast"         => true,
            "ImageReplacement" => true
        ];
        $options = array_merge($options, $params);

        switch ($icon) {
            case 1:
                $class .= ($class !== '' ? ' ' : '') . 'a11yc-wc';
                break;
            case 2:
                $class .= ($class !== '' ? ' ' : '') . 'a11yc-vd';
                break;
        }

        return
        '<div ' . ($class !== '' ? 'class="' . $class . '" ' : '') . 'id="accessconfig" data-accessconfig-buttonname="' .
        ($label ? html::escapeHTML($label) : __('Accessibility parameters')) . '" ' .
        'data-accessconfig-params=\'' . json_encode($options) . '\'>' .
            '</div>';
    }
}
