<?php
/**
 * Created by PhpStorm.
 * User: razor
 * Date: 2/5/2018
 * Time: 10:25 PM
 */

namespace inc\Api\Callbacks;


use inc\Base\BaseController;

class ManagerCallbacks extends BaseController
{
    public function checkboxSanitize($input)
    {
        $output = array();
        foreach ($this->managers as $key => $value){
            $output[$key] = isset($input[$key]) ? true : false;
        }
        return $output;
        //return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
        //return (isset($input) ? true : false);
    }

    public function rzaCustomSettings($input)
    {
        $output = array();
        foreach ($this->main_settings as $key => $value){
            $output[$key] = isset($input[$key]) ? $input[$key] : false;
        }
        return $output;
    }

    public function adminSectionManager()
    {
        echo 'Manage the sections and Features of this Plugin by activating the checkboxes from the following list.';
    }

    public function FieldGen($args)
    {
        $type   = $args['type'];
        $classes = $args['class'];
        $name     = $args['label_for'];
        $placeholder     = ($args['$placeholder'] ? $args['$placeholder'] : '');
        $option_name = $args['option_name'];
        $value = get_option($option_name);
        switch ($type){
            case 'textarea':
                echo '<textarea rows="5" id="' . $name . '" name="' . $option_name.'['.$name . ']" placeholder="{embed_code} - {title} - {duration}">' . (isset($value[$name]) ? $value[$name] : '') . '</textarea>';
                break;
            case 'text':
                echo '<input type="' . $type . '" id="' . $name . '" class="regular-text" name="' . $option_name.'['.$name . ']" value="' . (isset($value[$name]) ? $value[$name] : '') . '" placeholder="' . $placeholder . '" />';
                break;
            case 'checkbox':
                $checked = isset($value[$name]) ? ($value[$name] ? true : false) : false;
                echo '<div class="'.$classes.'"><input type="' . $type . '" id="' . $name . '" name="' . $option_name.'['.$name . ']" value="1" '.($checked ? 'checked' : '').'><label for="'.$name.'"><div></div></label></div>';
                break;
        }
        return;
    }

}