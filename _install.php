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
if (!defined('DC_CONTEXT_ADMIN')) {
    return;
}

if (!dcCore::app()->newVersion(basename(__DIR__), dcCore::app()->plugins->moduleInfo(basename(__DIR__), 'version'))) {
    return;
}

try {
    // Default blog settings
    dcCore::app()->blog->settings->a11yConfig->put('active', false, 'boolean', 'Active', false, true);

    dcCore::app()->blog->settings->a11yConfig->put('injection', false, 'boolean', 'Automatic insertion', false, true);
    dcCore::app()->blog->settings->a11yConfig->put('label', 'Accessibility parameters', 'string', 'Label', false, true);
    dcCore::app()->blog->settings->a11yConfig->put('icon', 0, 'integer', 'Icon', false, true);
    dcCore::app()->blog->settings->a11yConfig->put('position', 0, 'integer', 'Position', false, true);

    dcCore::app()->blog->settings->a11yConfig->put('font', true, 'boolean', 'Font adaptation', false, true);
    dcCore::app()->blog->settings->a11yConfig->put('linespacing', true, 'boolean', 'Line spacing adaptation', false, true);
    dcCore::app()->blog->settings->a11yConfig->put('justification', true, 'boolean', 'justification adaptation', false, true);
    dcCore::app()->blog->settings->a11yConfig->put('contrast', true, 'boolean', 'contrast adaptation', false, true);
    dcCore::app()->blog->settings->a11yConfig->put('image', true, 'boolean', 'Image replacement', false, true);

    // Default user settings
    dcCore::app()->auth->user_prefs->a11yConfig->put('active', true, 'boolean', 'Active', false, true);

    dcCore::app()->auth->user_prefs->a11yConfig->put('label', 'Accessibility parameters', 'string', 'Label', false, true);
    dcCore::app()->auth->user_prefs->a11yConfig->put('icon', 0, 'integer', 'Icon', false, true);
    dcCore::app()->auth->user_prefs->a11yConfig->put('position', 0, 'integer', 'Position', false, true);

    dcCore::app()->auth->user_prefs->a11yConfig->put('font', true, 'boolean', 'Font adaptation', false, true);
    dcCore::app()->auth->user_prefs->a11yConfig->put('linespacing', true, 'boolean', 'Line spacing adaptation', false, true);
    dcCore::app()->auth->user_prefs->a11yConfig->put('justification', true, 'boolean', 'justification adaptation', false, true);
    dcCore::app()->auth->user_prefs->a11yConfig->put('contrast', true, 'boolean', 'contrast adaptation', false, true);
    dcCore::app()->auth->user_prefs->a11yConfig->put('image', true, 'boolean', 'Image replacement', false, true);

    return true;
} catch (Exception $e) {
    dcCore::app()->error->add($e->getMessage());
}

return false;
