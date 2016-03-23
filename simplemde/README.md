# SimpleMDE Add-on for Statamic

This lets you use the [SimpleMDE Markdown Editor](https://github.com/NextStepWebs/simplemde-markdown-editor) in the [Statamic](http://statamic.com) control panel.

**Note:** Currently, this is only compatible with Statamic v1.

## Installation

Copy the `simplemde` folder to the `_add-ons` folder.

## Configuration

Set your field's `type:` parameter to `simplemde`.

There are 3 parameters for configuration:

* `height`  
  The minimum height, in pixels, that you want the field to render.  
  
  **_Default:_** 300
* `preserve_characters`  
  Remove or keep certain special characters, as entered. In my experience, "Smart" quotes tend to make RSS/Atom feeds become invalid, so this gives you the option to convert them.  
  
  Changed characters: `‘`, `’`, `“`, `”`, `–`, `—`, and `…`

  The last 3 characters are converted to `&ndash;`, `&mdash;`, and `...`, respectively.  
  
  **_Default:_** false
  
* `relative_urls`  
  Removes all references to the current domain name in links and images.

  For example, if you are running Statamic on partyonwayne.com, a markdown link to  
  `[Sweet website, bro!](https://partyonwayne.com/my/cool/page.html)`  
  will become  
  `[Sweet website, bro!](/my/cool/page.html)`.
  
  **_Default:_** true
  
**Note:** `height` is rendered after the Control Panel page is loaded. `preserve_characters` and `relative_urls` are processed when the page/entry is submitted.

### Example fieldset.yaml

Here's a non-standard field configuration:

```
fields:
  post_body:
    display: Body Copy
    type: simplemde
    height: 500
    preserve_characters: true
    relative_urls: false
```
