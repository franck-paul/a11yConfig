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
    '6.1',
    [
        'date'        => '2025-06-01T08:07:34+0200',
        'requires'    => [['core', '2.34']],
        'permissions' => 'My',
        'type'        => 'plugin',
        'settings'    => [
            'self' => '',
            'pref' => '#user-options.a11yConfig',
        ],

        'details'    => 'https://open-time.net/?q=a11yConfig',
        'support'    => 'https://github.com/franck-paul/a11yConfig',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/a11yConfig/main/dcstore.xml',
        'license'    => 'gpl2',
    ]
);
