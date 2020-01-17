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

$a11yc_positions = [
    a11yconfigConst::IN_TOP    => __('In header'),
    a11yconfigConst::IN_BOTTOM => __('In footer')
];

$a11yc_icons = [
    a11yconfigConst::ICON_NONE             => __('No'),
    a11yconfigConst::ICON_WHEELCHAIR       => __('Wheelchair'),
    a11yconfigConst::ICON_VISUALDEFICIENCY => __('Visual deficiency')
];

$a11yc_active = (boolean) $core->blog->settings->a11yConfig->active;

$a11yc_injection = (boolean) $core->blog->settings->a11yConfig->injection;
$a11yc_label     = $core->blog->settings->a11yConfig->label;
$a11yc_icon      = (integer) $core->blog->settings->a11yConfig->icon;
$a11yc_position  = (integer) $core->blog->settings->a11yConfig->position;

$a11yc_font          = (boolean) $core->blog->settings->a11yConfig->font;
$a11yc_linespacing   = (boolean) $core->blog->settings->a11yConfig->linespacing;
$a11yc_justification = (boolean) $core->blog->settings->a11yConfig->justification;
$a11yc_contrast      = (boolean) $core->blog->settings->a11yConfig->contrast;
$a11yc_image         = (boolean) $core->blog->settings->a11yConfig->image;

if (!empty($_POST)) {
    try
    {
        $a11yc_active = !empty($_POST['a11yc_active']);

        $a11yc_injection     = !empty($_POST['a11yc_injection']);
        $a11yc_label         = html::escapeHTML($_POST['a11yc_label']);
        $a11yc_icon          = abs((integer) $_POST['a11yc_icon']);
        $a11yc_position      = abs((integer) $_POST['a11yc_position']);
        $a11yc_font          = !empty($_POST['a11yc_font']);
        $a11yc_linespacing   = !empty($_POST['a11yc_linespacing']);
        $a11yc_justification = !empty($_POST['a11yc_justification']);
        $a11yc_contrast      = !empty($_POST['a11yc_contrast']);
        $a11yc_image         = !empty($_POST['a11yc_image']);

        # Everything's fine, save options
        $core->blog->settings->addNamespace('a11yConfig');

        $core->blog->settings->a11yConfig->put('active', $a11yc_active);

        $core->blog->settings->a11yConfig->put('injection', $a11yc_injection);
        $core->blog->settings->a11yConfig->put('label', $a11yc_label);
        $core->blog->settings->a11yConfig->put('icon', $a11yc_icon);
        $core->blog->settings->a11yConfig->put('position', $a11yc_position);
        $core->blog->settings->a11yConfig->put('font', $a11yc_font);
        $core->blog->settings->a11yConfig->put('linespacing', $a11yc_linespacing);
        $core->blog->settings->a11yConfig->put('justification', $a11yc_justification);
        $core->blog->settings->a11yConfig->put('contrast', $a11yc_contrast);
        $core->blog->settings->a11yConfig->put('image', $a11yc_image);

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
'<p>' . form::checkbox('a11yc_active', 1, $a11yc_active) . ' ' .
'<label for="a11yc_active" class="classic">' . __('Activate a11yConfig on blog') . '</label></p>';

echo
'<p class="form-note">' . sprintf(__('A widget is available (see <a href="%s">%s</a>)'), $core->adminurl->get('admin.plugin.widgets'), __('Presentation widgets')) . '</p>';

echo
'<h3>' . __('Automatic insertion') . '</h3>' .
'<p>' . form::checkbox('a11yc_injection', 1, $a11yc_injection) . ' ' .
'<label for="a11yc_injection" class="classic">' . __('Automatic insertion') . '</label></p>';

echo
'<p><label for="a11yc_label" class="required" title="' . __('Required field') . '"><abbr title="' . __('Required field') . '">*</abbr> ' . __('Label:') . '</label> ' .
form::field('a11yc_label', 30, 256, html::escapeHTML($a11yc_label), '', '', false, 'required placeholder="' . __('Accessibility parameters') . '"') .
    '</p>';

// Options for button appearance
echo '<h4>' . __('Icon:') . '</h4>';
echo
'<p class="form-note">' . __('The previous label will be used as alternative text if one of proposed icons is choosen.') . '</p>';
$i = 0;
foreach ($a11yc_icons as $k => $v) {
    echo '<p><label for="a11yc_icon_' . $i . '" class="classic">' .
    form::radio(['a11yc_icon', 'a11yc_icon_' . $i], $k, $a11yc_icon == $k) . ' ' . $v . '</label></p>';
    $i++;
}

// Options for automatic insertion
echo '<h4>' . __('Position:') . '</h4>';
echo
'<p class="form-note">' . __('The automatic insertion in header depends on the <strong>publicTopAfterContent</strong> behavior and in footer on <strong>publicFooterContent</strong> behavior. Adapt theme\'s template files if necessary.') . '</p>';
$i = 0;
foreach ($a11yc_positions as $k => $v) {
    echo '<p><label for="a11yc_position_' . $i . '" class="classic">' .
    form::radio(['a11yc_position', 'a11yc_position_' . $i], $k, $a11yc_position == $k) . ' ' . $v . '</label></p>';
    $i++;
}

echo '<h4>' . __('Options:') . '</h4>';
echo
'<p>' . form::checkbox('a11yc_font', 1, $a11yc_font) . ' ' .
'<label for="a11yc_font" class="classic">' . __('Font adaptation') . '</label></p>' .
'<p>' . form::checkbox('a11yc_linespacing', 1, $a11yc_linespacing) . ' ' .
'<label for="a11yc_linespacing" class="classic">' . __('Line Spacing adaptation') . '</label></p>' .
'<p>' . form::checkbox('a11yc_justification', 1, $a11yc_justification) . ' ' .
'<label for="a11yc_justification" class="classic">' . __('Justification adaptation') . '</label></p>' .
'<p>' . form::checkbox('a11yc_contrast', 1, $a11yc_contrast) . ' ' .
'<label for="a11yc_contrast" class="classic">' . __('Contrast adaptation') . '</label></p>' .
'<p>' . form::checkbox('a11yc_image', 1, $a11yc_image) . ' ' .
'<label for="a11yc_image" class="classic">' . __('Image replacement') . '</label></p>';

echo
'<p>' . $core->formNonce() . '<input type="submit" value="' . __('Save') . '" /></p>' . '</form>';

?>
</body>
</html>
