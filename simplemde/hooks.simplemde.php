<?php
class Hooks_simplemde extends Hooks {

  public function control_panel__add_to_head()
  {
    if (URL::getCurrent(false) == '/publish') {
      return "\n\n".$this->js->link("simplemde.min.js") . $this->css->link("simplemde.min.css") . $this->css->link("tweaks.css");
    }
  }

}
