# a11yConfig

[![Release](https://img.shields.io/github/v/release/franck-paul/a11yConfig)](https://github.com/franck-paul/a11yConfig/releases)
[![Date](https://img.shields.io/github/release-date/franck-paul/a11yConfig)](https://github.com/franck-paul/a11yConfig/releases)
[![Issues](https://img.shields.io/github/issues/franck-paul/a11yConfig)](https://github.com/franck-paul/a11yConfig/issues)
[![Dotaddict](https://img.shields.io/badge/dotaddict-official-green.svg)](https://plugins.dotaddict.org/dc2/details/a11yConfig)
[![License](https://img.shields.io/github/license/franck-paul/a11yConfig)](https://github.com/franck-paul/a11yConfig/blob/master/LICENSE)

Dotclear 2 plugin which embed the [Access42 AccessConfig tool](https://accessconfig.a11y.fr/)

This tool, which propose some settings to enforce web page readability, is activable for the blog **and/or** the Dotclear backend (user prefs).

The currently proposed settings are:

1. Contrast reinforcement/inversion
1. Font replacement (dyslexia)
1. Line spacing
1. Justification
1. Image replacement

The settings will be accessible via a dialog form opened by a button. The plugin provides a widget (with the button) or automatically inserts this button in header or footer of the blog, and, for the Administration side, inserts a button in the header or the footer.

This button may be displayed as a wheelchair or a visual deficiency icon.

## Dotclear template engine

The widget may be directly inserted in one of the theme's template file by using this code:

```xml
<tpl:Widget id="a11yConfig">
    <setting name="buttonname">Accessibility parameters</setting>
    <setting name="icon">0</setting> (1 = wheelchair, 2 = visual deficiency)
    <setting name="font">1</setting> (0 = disable this option)
    <setting name="linespacing">1</setting> (0 = disable this option)
    <setting name="justification">1</setting> (0 = disable this option)
    <setting name="contrast">1</setting> (0 = disable this option)
    <setting name="image">1</setting> (0 = disable this option)
    <setting name="offline">0</setting> (1 = hide this widget)
</tpl:Widget>
```

Note: all settings are optionals and their default value are given above (for English)

A template tag is also provided and may be inserted using this code:

```xml
{{tpl:AccessConfig [option [option […]]]}}
```

Where options are:

* title="Accessibility parameters"
* icon="0" (1 = wheelchair, 2 = visual deficiency)
* font="1" (0 = disable this option)
* linespacing="1" (0 = disable this option)
* justification="1" (0 = disable this option)
* contrast="1" (0 = disable this option)
* image="1" (0 = disable this option)

Note: values given for options are the default values used if the option is not present so no options at all is equivalent to:

```xml
{{tpl:AccessConfig title="Accessibility parameters" icon="0" font="1" linespacing="1" justification="1" contrast="1" image="1"}}
```

## Support

[Source code and issues](https://github.com/franck-paul/a11yConfig)

## Notes about reinforced/inverted constrast in Dotclear backend

* It's recommended to disable the syntax highlighting for the theme editor (see "My preferences" > "My options" > "Other options" > "Syntax highlighting") otherwise the selected text and the cursor will not be visible.

* This option will not be applied to CKEditor; you should switch back to the Legacy Editor if necessary for HTML edition (see "My preferences" > "My options" > "Edition").

* In this mode the toolbar buttons of the Legacy editor will be replaced by their textual equivalent.

## Stylesheets SASS to CSS

To compile Sass sources to final and compressed CSS run the following command from the plugin root directory:

```bash
sass -s compressed --no-source-map  ./scss:./css
```

## Build package

To build the Dotclear 2 plugin package (using Dotclear provided tool):

```bash
cd plugins/a11yConfig
../../build-tools/build-module.sh
```

## Licence

See joined LICENCE file
