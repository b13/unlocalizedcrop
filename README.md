# Remove Cropping for File Reference Translations

This is a TYPO3 extension that disables the cropping functionality
for file references that are a translation. This means, that they have a reference
to a record in another language.

Under the hood, the cropping information from the original record is always kept in sync.

## When do I need this extension?

Imagine you have a TYPO3 installation with multiple translations. If you want to make sure the cropping value
is the same across all translations, use the extension. This way, you only need to modify the cropping information
in the original language, and the change will be applied to all translations.

It *does* limit your capabilities, because nobody could ever set a custom cropping information for a translation,
however we consider this a best practice for the use cases that we encountered. If you need to have custom cropping
information (or even a different picture), then it's not a translation anymore but just a record in a specific language.

## How to install

You can set this up via composer (`composer require b13/unlocalizedcrop`) or via TER (extension name "unlocalizedcrop"),
it runs with TYPO3 v8+.

There is a CLI command to migrate an existing installation with existing sys_file_reference records in translations
to have everything in sync from the beginning. Use it via `vendor/bin/typo3 unlocalizedcrop:migrate`.

## License

The extension is licensed under GPL v2+, same as the TYPO3 Core.

For details see LICENSE.txt in this repository.


## Credits

* Initial development: Benni Mack
* sponsored by b13 (www.b13.com)
