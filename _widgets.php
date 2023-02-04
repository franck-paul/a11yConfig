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

use Dotclear\Plugin\widgets\Widgets;

if (!(bool) dcCore::app()->blog->settings->a11yConfig->active) {
    return;
}

class a11yconfigWidget
{
    public static function initWidgets($w)
    {
        $w->create('a11yconfig', 'a11yconfig', ['a11yconfigPublic', 'a11yconfigWidget'], null, __('Style selector to let users adapt your blog to their needs.'));

        $w->a11yconfig->setting('buttonname', __('Title:'), __('Accessibility Settings'));
        $w->a11yconfig->setting('icon', __('Icon:'), a11yconfigConst::ICON_NONE, 'combo', [
            __('No')                => a11yconfigConst::ICON_NONE,
            __('Wheelchair')        => a11yconfigConst::ICON_WHEELCHAIR,
            __('Visual deficiency') => a11yconfigConst::ICON_VISUALDEFICIENCY,
        ]);

        $w->a11yconfig->setting('font', __('Font adaptation'), 1, 'check');
        $w->a11yconfig->setting('linespacing', __('Line Spacing adaptation'), 1, 'check');
        $w->a11yconfig->setting('justification', __('Justification adaptation'), 1, 'check');
        $w->a11yconfig->setting('contrast', __('Contrast adaptation'), 1, 'check');
        $w->a11yconfig->setting('image', __('Image replacement'), 1, 'check');

        $w->a11yconfig->setting('offline', __('Offline'), 0, 'check');
    }

    public static function initDefaultWidgets($w, $d)
    {
        $d[Widgets::WIDGETS_NAV]->append($w->a11yconfig);
    }
}

dcCore::app()->addBehaviors([
    'initWidgets'        => [a11yconfigWidget::class, 'initWidgets'],
    'initDefaultWidgets' => [a11yconfigWidget::class, 'initDefaultWidgets'],
]);
