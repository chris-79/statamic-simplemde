<?php
class Fieldtype_simplemde extends Fieldtype {

  var $meta = array(
    'name'       => 'SimpleMDE',
    'version'    => '0.2',
    'author'     => 'Chris S',
    'author_url' => 'https://github.com/chris-79'
  );

  static $field_settings;

  function render() {

    self::$field_settings = $this->field_config;

    $height = isset($this->field_config['height']) ? $this->field_config['height'].'px' : '300px';

    $html = <<<HTMLBLOCK
<div class='simplemde_container'>
  <textarea id='{$this->field_id}' name='{$this->fieldname}' style='height:{$height}'>{$this->field_data}</textarea>
  <script type='text/javascript'>
    var simplemde_{$this->tabindex} = new SimpleMDE({
      element: document.getElementById("{$this->field_id}"),
      blockStyles: { italic: "_" },
      insertTexts: {
          horizontalRule: ["\\n\\n-----\\n\\n",""],
          table: ["", "\\n\\n| Column 1 Heading | Column 2 Heading | Column 3 Heading |\\n| -------- | -------- | -------- |\\n| Text     | Text      | Text     |\\n\\n"],
      },
      showIcons: ["horizontal-rule","table"],
      // hideIcons: ["side-by-side","fullscreen"],
    });
  </script>
  <style scoped>
    #{$this->field_id} ~ .CodeMirror {
      min-height: {$height};
    }
  </style>
</div>
HTMLBLOCK;

    return $html;
  }

  public static function get_field_settings() {
    return self::$field_settings;
  }

  function remove_domain($content) {
    // Remove absolute URL references to this domain
    $content = preg_replace("/(\\()https?:\\/\\/".$_SERVER['SERVER_NAME']."/uim", '$1', $content);
    return $content;
  }

  function replace_chars($content) {
    // Replace UTF-8 quotes, dashes, and elipses.
    $content = str_replace(
                           array("\xe2\x80\x98", "\xe2\x80\x99", "\xe2\x80\x9c", "\xe2\x80\x9d", "\xe2\x80\x93", "\xe2\x80\x94", "\xe2\x80\xa6"),
                           array("'", "'", '"', '"', '&ndash;', '&mdash;', '...'),
                           $content);
    // Replace Windows-1252 equivalents.
    $content = str_replace(
                           array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(133)),
                           array("'", "'", '"', '"', '&ndash;', '&mdash;', '...'),
                           $content);
    //
    $content = str_replace(
                           array("‘", "’", '“', '”', '–', '—', '…'),
                           array("'", "'", '"', '"', '&ndash;', '&mdash;', '...'),
                           $content);
    return $content;
  }

  function clean_em($content) {
    $preserve_chars = isset($this->field_config['preserve_characters']) ? $this->field_config['preserve_characters'] : false;
    $relative_urls = isset($this->field_config['relative_urls']) ? $this->field_config['relative_urls'] : true;

    if (!$preserve_chars) {
      $content = $this->replace_chars($content);
    }
    if ($relative_urls) {
      $content = $this->remove_domain($content);
    }
    return $content;
  }

  function process() {
    return $this->clean_em(trim($this->field_data));
  }

}
