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

// Get current options
$core->blog->settings->addNamespace('a11yConfig');
$ac_active = (boolean) $core->blog->settings->a11yConfig->active;

if (!empty($_POST)) {
    try
    {
        $ac_active = !empty($_POST['ac_active']);

        # Everything's fine, save options
        $core->blog->settings->addNamespace('a11yConfig');
        $core->blog->settings->a11yConfig->put('active', $ac_active);

        $core->blog->triggerBlog();

        dcPage::addSuccessNotice(__('Settings have been successfully updated.'));
        http::redirect($p_url);
    } catch (Exception $e) {
        $core->error->add($e->getMessage());
    }
}

?>
<html>
<head>
  <title><?php echo __('a11yConfig'); ?></title>
</head>

<body>
<?php
echo dcPage::breadcrumb(
    [
        html::escapeHTML($core->blog->name) => '',
        __('a11yConfig')                    => ''
    ]);
echo dcPage::notices();

echo
'<form action="' . $p_url . '" method="post">' .
'<p>' . form::checkbox('ac_active', 1, $ac_active) . ' ' .
'<label for="ac_active" class="classic">' . __('Active a11yConfig') . '</label></p>' .
'<p>' . $core->formNonce() . '<input type="submit" value="' . __('Save') . '" /></p>' .
    '</form>';

?>
</body>
</html>
