<?php

/**
 * @brief a11yConfig, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul, Biou and contributors
 *
 * @copyright Franck Paul contact@open-time.net
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

if (isset($this) && is_object($this) && method_exists($this, 'registerModule') && isset($this->id) && is_string($this->id)) {
    $this->registerModule(
        'a11yConfig',
        'Implements Access42 accessibility configuration tool',
        'Franck Paul, Biou and contributors',
        '8.1',
        [
            'date'        => '2026-11-07T16:38:08+0100',
            'requires'    => [['core', '2.39']],
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
}
