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

if (!defined('DC_CONTEXT_ADMIN')) {return;}

$new_version = $core->plugins->moduleInfo('a11yConfig', 'version');
$old_version = $core->getVersion('a11yConfig');

if (version_compare($old_version, $new_version, '>=')) {
    return;
}

try
{
    $core->blog->settings->addNamespace('a11yConfig');
    $core->blog->settings->a11yConfig->put('active', false, 'boolean', 'Active', false, true);

    $core->setVersion('a11yConfig', $new_version);

    return true;
} catch (Exception $e) {
    $core->error->add($e->getMessage());
}
return false;
