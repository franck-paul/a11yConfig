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
if (!defined('DC_RC_PATH')) {
    return;
}

$this->registerModule(
    'a11yConfig',                                           // Name
    'Implements Access42 accessibility configuration tool', // Description
    'Franck Paul, Biou and contributors',                   // Author
    '1.7',
    [
        'requires'    => [['core', '2.23']],
        'permissions' => 'usage,contentadmin',                        // Permissions
        'type'        => 'plugin',                                    // Type
        'settings'    => [                                            // Settings
            'self' => '',
            'pref' => '#user-options.a11yConfig',
        ],

        'details'    => 'https://open-time.net/?q=a11yConfig',       // Details URL
        'support'    => 'https://github.com/franck-paul/a11yConfig', // Support URL
        'repository' => 'https://raw.githubusercontent.com/franck-paul/a11yConfig/master/dcstore.xml',
    ]
);
