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

use Dotclear\Plugin\widgets\Widgets as AppWidgets;
use Dotclear\Plugin\widgets\WidgetsStack;

class Widgets
{
    private const WIDGET_ID = 'a11yconfig';

    public static function initWidgets(WidgetsStack $w): string
    {
        $w
            ->create(self::WIDGET_ID, 'a11yconfig', FrontendWidgets::renderWidget(...), null, __('Style selector to let users adapt your blog to their needs.'))
            ->setting('buttonname', __('Title:'), __('Accessibility Settings'))
            ->setting('icon', __('Icon:'), Prepend::ICON_NONE, 'combo', [
                __('No')                => Prepend::ICON_NONE,
                __('Wheelchair')        => Prepend::ICON_WHEELCHAIR,
                __('Visual deficiency') => Prepend::ICON_VISUALDEFICIENCY,
            ])
            ->setting('font', __('Font adaptation'), 1, 'check')
            ->setting('linespacing', __('Line Spacing adaptation'), 1, 'check')
            ->setting('justification', __('Justification adaptation'), 1, 'check')
            ->setting('contrast', __('Contrast adaptation'), 1, 'check')
            ->setting('image', __('Image replacement'), 1, 'check')
            ->setting('offline', __('Offline'), 0, 'check');

        return '';
    }

    /**
     * Initializes the default widgets.
     *
     * @param      \Dotclear\Plugin\widgets\WidgetsStack    $w  Widgets stack
     * @param      array<string, WidgetsStack>              $d  Widgets definitions
     */
    public static function initDefaultWidgets(WidgetsStack $w, array $d): void
    {
        $d[AppWidgets::WIDGETS_NAV]->append($w->get(self::WIDGET_ID));
    }
}
