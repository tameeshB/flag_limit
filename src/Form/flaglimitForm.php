<?php

/**
*@file
*Contains \Drupal\flag_limit\Form\flaglimitForm
*/

namespace Drupal\flag_limit\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* Flag settings form.
*/
class flaglimitForm extends ConfigFormBase{

  /**
  *
  */
  public function getFormId() {
    return 'flag_limit_settings_form';
  }

   /**
  *
  */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $flags = flag_get_flags();
    foreach($flags as $flag) {
	  $form['flag_limit_' . $flag->name]= array(
	    '#type' => 'checkbox',
	    '#title' => t('Impose a Limit on !flag', array('!flag' => $flag->title)),
	    '#default_value' => \Drupal::state()->get('flag_limit_' . $flag->name, FALSE),
	    );
	    
	  $form['flag_limit_' . $flag->name . '_value']= array(
	    '#type' => 'textfield',
	    '#title' => t('!flag Limit', array('!flag' => $flag->title)),
	    '#description' => t('Maximum number of items that can be flagged at one time with <em>!flag</em>', array('!flag' => $flag->title)),
	    '#default_value' => \Drupal::state()->get('flag_limit_' . $flag->name . '_value', NULL),
	  );
	}

	return parent::buildForm($form, $form_state);
  }
	
  /**
  * 
  */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $flags = flag_get_flags();

    foreach($flags as $flag) {
    	$flag_field_name='flag_limit_' . $flag->name . '_value';
    	$config->set($flag_field_name,$form_state->getValue($flag_field_name));
    }
    
    // Set the values the user submitted in the form
    $config->save();
  }
}

?>