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

class a11yconfigPublic
{
    public static function publicHeadContent($core)
    {
        global $core;

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

        $params = array("Prefix" => "a42-ac",
            "Modal"                  => true,
            "Font"                   => ($w->font ? true : false),
            "LineSpacing"            => ($w->linespacing ? true : false),
            "Justification"          => ($w->justification ? true : false),
            "Contrast"               => ($w->contrast ? true : false),
            "ImageReplacement"       => ($w->image ? true : false)
        );

        $res =
        '<div class="widget" id="accessconfig" data-accessconfig-buttonname="' .
        ($w->buttonname ? html::escapeHTML($w->buttonname) : '') . '" ' .
        'data-accessconfig-params=\'' . json_encode($params) . '\'>' .
        '</div>';

        return $res;
    }
}
