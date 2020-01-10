# a11yConfig

Dotclear 2 plugin which embed the [Access42 AccessConfig tool](https://accessconfig.a11y.fr/)

[Support](https://github.com/franck-paul/a11yConfig)

## Stylesheets SASS to CSS

To compile Sass sources to final and compressed CSS run the following command from the plugin root directory:

```bash
sass --watch -s compressed --no-source-map  ./scss:./css
```

## Notes about enabling reinforced/inverted constrast in Dotclear administration

* It's recommended to disable the syntax highlighting for the theme editor (see "My preferences" > "My options" > "Other options" > "Syntax highlighting") otherwise the selected text and the cursor will not be visible.

* This option will not be applied to CKEditor; you should switch back to the Legacy Editor if necessary for HTML edition (see "My preferences" > "My options" > "Edition").

* If this mode the toolbar buttons of the Legacy editor will be replaced by their textual equivalent.
