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

use Dotclear\Plugin\widgets\Widgets as dcWidgets;
use Dotclear\Plugin\widgets\WidgetsStack;

class Widgets
{
    public static function initWidgets(WidgetsStack $w)
    {
        $w->create('a11yconfig', 'a11yconfig', [FrontendWidgets::class, 'renderWidget'], null, __('Style selector to let users adapt your blog to their needs.'));

        $w->a11yconfig->setting('buttonname', __('Title:'), __('Accessibility Settings'));
        $w->a11yconfig->setting('icon', __('Icon:'), Prepend::ICON_NONE, 'combo', [
            __('No')                => Prepend::ICON_NONE,
            __('Wheelchair')        => Prepend::ICON_WHEELCHAIR,
            __('Visual deficiency') => Prepend::ICON_VISUALDEFICIENCY,
        ]);

        $w->a11yconfig->setting('font', __('Font adaptation'), 1, 'check');
        $w->a11yconfig->setting('linespacing', __('Line Spacing adaptation'), 1, 'check');
        $w->a11yconfig->setting('justification', __('Justification adaptation'), 1, 'check');
        $w->a11yconfig->setting('contrast', __('Contrast adaptation'), 1, 'check');
        $w->a11yconfig->setting('image', __('Image replacement'), 1, 'check');

        $w->a11yconfig->setting('offline', __('Offline'), 0, 'check');
    }

    public static function initDefaultWidgets(WidgetsStack $w, array $d)
    {
        $d[dcWidgets::WIDGETS_NAV]->append($w->a11yconfig);
    }
}
