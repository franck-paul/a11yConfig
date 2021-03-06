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

$this->registerModule(
    "a11yConfig",                                           // Name
    "Implements Access42 accessibility configuration tool", // Description
    "Franck Paul, Biou and contributors",                   // Author
    '1.5',                                                  // Version
    [
        'requires'    => [['core', '2.15']],
        'permissions' => 'usage,contentadmin',                        // Permissions
        'type'        => 'plugin',                                    // Type
        'support'     => 'https://github.com/franck-paul/a11yConfig', // Support URL
        'settings'    => [                                            // Settings
            'self' => '',
            'pref' => '#user-options.a11yConfig'
        ]
    ]
);
