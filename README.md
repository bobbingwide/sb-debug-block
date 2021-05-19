# Debug block 
* Contributors:      bobbingwide
* Tags:              block, debug, scaffold, SSR
* Tested up to:      5.7.0
* Stable tag:        0.0.0
* License:           GPL-2.0-or-later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Single block server side rendered Debug block.

## Description 
The Debug block displays debugging information for WordPress Full Site Editing (FSE) themes.
Depending on where it's used and attributes the debug block will display useful information
when you're developing an FSE theme.

- Template information
- Template part information
- Post content information

The debug block only produces output when the WP_DEBUG constant is true.
It doesn't check WP_DEBUG_DISPLAY not SCRIPT_DEBUG.

There is no need to remove the debug blocks from the source.
When the Debug block plugin isn't activated or WP_DEBUG isn't true the block will not be rendered.

In its simplest form the debug block is

```
<!-- wp:oik-sb/sb-debug-block /-->
```

Attributes (will) allow you to provide additional information

- debug - any text you want included in the debug block's output
- showTemplate - true/false - to include the escaped HTML for the template
- showTemplatePart - true/false - to include the escaped HTML for the template part
- showContents - true/false - to include the escaped HTML for the post content


## Installation 

1. Edit wp-config.php to set WP_DEBUG to true.
2. Install and activate the plugin.
3. Use the Debug block in your templates, template parts or content.



## Screenshots 
1. Debug block - rendered
2. Debug block - settings

## Upgrade Notice 
# 0.0.0 
Prototype version to support the Gutenberg feature request for two new action hooks

## Changelog 
# 0.0.0 
* Added: First version of the server side rendered block,[#1](https://github.com/bobbingwide/sb-debug-block/issues/1)
* Added: Implement debugging for templates and template parts,[#2](https://github.com/bobbingwide/sb-debug-block/issues/2)
* Tested: With WordPress 5.7.2 and WordPress Multi Site
* Tested: With Gutenberg 10.6.0
* Tested: With PHP 8.0
