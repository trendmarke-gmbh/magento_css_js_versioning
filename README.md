# Magento Css and JS Versioning
Magento automatically generates a hash as filename for the merged assets (CSS/JS). This is create however if you change something it often occurs that the filename stays the same what leads to issues with browser caching (i.e. the old file is taken from the browser cache).
This litle extensions add a timestamp to the merged asset filenames and thereby solves issues with browser caching. Thereby, it always takes the timestamp of the last edited file to ensure that the newest content is loaded and if nothing is changed you can still benefit from browser caching.

## Installation
**Manual:** Download the extension and copy the contents of the src folder in your magento root folder
**Modman:** Simply run 
```bash 
$ modman clone https://github.com/trendmarke-gmbh/magento_css_js_versioning
```
[More information about modman](https://github.com/colinmollenhour/modman)

## Add Htaccass-Rule
Since this extensions changes the url from something like:
`http://www.example.de/media/css/hash.css` to `http://www.example.de/media/css/hash.123.css`
you need the following htaccess rules placed in your **`/media/.htaccess`** file (If this file does not exists create it or add the rules to the htaccess file in your root).
```
RewriteRule (.*)\.(\d{10})\.(css)$ $1.$3 [L,NC]
RewriteRule (.*)\.(\d{10})\.(js)$ $1.$3 [L,NC]
```

## Notes and Credits
* This extension was tested with Magento 1.9.x but it should also work with older versions (probably till 1.4.x).
* This extension was inspired by a snippet of [smithweb](https://gist.github.com/smithweb/4746695)
* This extension also fixes a bug with inline content in merged css [more information](https://github.com/just-better/magento1-css-merge-data-uri-fix)