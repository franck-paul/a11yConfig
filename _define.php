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
$this->registerModule(
    'a11yConfig',
    'Implements Access42 accessibility configuration tool',
    'Franck Paul, Biou and contributors',
    '4.0',
    [
        'requires'    => [['core', '2.28']],
        'permissions' => dcCore::app()->auth->makePermissions([
            dcAuth::PERMISSION_USAGE,
            dcAuth::PERMISSION_CONTENT_ADMIN,
        ]),
        'type'     => 'plugin',
        'settings' => [
            'self' => '',
            'pref' => '#user-options.a11yConfig',
        ],

        'details'    => 'https://open-time.net/?q=a11yConfig',
        'support'    => 'https://github.com/franck-paul/a11yConfig',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/a11yConfig/master/dcstore.xml',
    ]
);
