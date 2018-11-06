<?php
namespace Core;

class Form {

  private $_form;

  public function __construct($fields = null, $id, $submit){

    $this->_form = '<form action="" method="POST">';
    if ($fields)
    {
      foreach($fields as $key => $option) {
        if (isset($option['type']) && $option['type'] == 'textarea')
          $this->_form .= self::create_textarea($key, $option);
        else if (isset($option['type']) && $option['type'] == 'checkbox')
          $this->_form .= self::create_checkbox($key, $option);
        else
          $this->_form .= self::create_input($key, $option);
      }
    }
    $this->_form .= self::create_submit($submit, $id);
    $this->_form .= '</form>';
  }

  public function create_checkbox($name, $option) {
    $checked = ($option['checked'] === "1" ? "checked" : "");
    $field = str_replace("_", " ", ucfirst($name));
    $field .= '  <input class="forms_account" type="'.$option['type'].'"';
    $field .= ' name="' . $name . '" '.$checked.'>';
    return $field;
  }

  public function create_input($name, $option) {
    $required = isset($option['required']);
    $type = isset($option['type']) ? $option['type'] : 'text';
    $field = '<label for="' . ucfirst($name) . '" class="forms_account">' . str_replace("_", " ", ucfirst($name)) .
              ($required ? "*":"") . '</label>' .
              '<input class="forms_input_text" type="' . $type . '" name="' . $name .
              '" ' . ($required ? 'required' : '') . ' maxlength="50">';
    return $field;
  }

  public function create_textarea($name, $option) {
    $area =  '<label for="' . ucfirst($name) . '" class="forms_account">' . str_replace("_", " ", ucfirst($name)) . '</label>' .
              '<textarea class="forms_input_text" name="' . $name .
              '" ' . (isset($option['required']) ? 'required' : '') . ' cols="50" rows="3" maxlength="200">' .
              '</textarea>';
    return $area;
  }

  public function create_submit($submit, $id){
    $button = '<button class="forms_input" type="submit" name="'.$submit.'"';
    if (isset($id))
      $button .= 'value="'.$id.'">';
    else
      $button .= 'value="OK">';
    $button .= $submit .'</button>';
    return $button;
  }

  public function __toString()
 {
     return $this->_form;
 }

}
