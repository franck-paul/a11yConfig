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
use Dotclear\Module\MyPlugin;

/**
 * Plugin definitions
 */
class My extends MyPlugin
{
    /**
     * Return URL regexp scheme cope by the plugin
     *
     * @return     string
     */
    public static function urlScheme(): string
    {
        return '/' . preg_quote(dcCore::app()->admin->url->get('admin.plugin.' . self::id())) . '(&.*)?$/';
    }

    /**
     * Makes an url including optionnal parameters.
     *
     * @param      array   $params  The parameters
     *
     * @return     string
     */
    public static function makeUrl(array $params = []): string
    {
        return self::manageUrl($params);
    }
}
