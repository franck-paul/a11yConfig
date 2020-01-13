# a11yConfig

Dotclear 2 plugin which embed the [Access42 AccessConfig tool](https://accessconfig.a11y.fr/)

This tool, which propose some settings to enforce web page readability, is activable for the blog **and/or** the Dotclear administration (user prefs).

The currently proposed settings are:

1. Contrast reinforcement/inversion
1. Font replacement (dyslexia)
1. Line spacing
1. Justification
1. Image replacement

The settings will be accessible via a dialog form opened by a button. The plugin provides a widget (with the button) or automatically inserts this button in header or footer of the blog, and, for the Administration side, inserts a button in the header or the footer.

This button may be displayed as a wheelchair or a visual deficiency icon.

## Support

[Source code and issues](https://github.com/franck-paul/a11yConfig)

## Notes about reinforced/inverted constrast in Dotclear administration

* It's recommended to disable the syntax highlighting for the theme editor (see "My preferences" > "My options" > "Other options" > "Syntax highlighting") otherwise the selected text and the cursor will not be visible.

* This option will not be applied to CKEditor; you should switch back to the Legacy Editor if necessary for HTML edition (see "My preferences" > "My options" > "Edition").

* In this mode the toolbar buttons of the Legacy editor will be replaced by their textual equivalent.

## Stylesheets SASS to CSS

To compile Sass sources to final and compressed CSS run the following command from the plugin root directory:

```bash
sass -s compressed --no-source-map  ./scss:./css
```

## Licence

See joined LICENCE file
