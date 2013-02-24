<?php
/**
 * Created by JetBrains PhpStorm.
 * User: paul
 * Date: 23/02/13
 * Time: 15:36
 * To change this template use File | Settings | File Templates.
 */
require_once 'FormField.php';

class FormTextField extends FormField {

	/**
	 * Builds and returns the field as HTML
	 * @return string|void
	 */
	public function render() {
		$attributes = (object) $this->attributes;
		$label = "<div><label for='" . htmlentities( $attributes->name ) . "'>"
				. htmlentities( $attributes->label ) . "</label>" . PHP_EOL;
		$input = "<input placeholder='" . htmlentities( $attributes->placeholder )
				. "' type='text' id='" . htmlentities( $attributes->name ) . "' name='" . htmlentities( $this->group . "[" . $attributes->name . "]" )
				. "' size='" . htmlentities( $attributes->size ) . "' maxlength='" . htmlentities( $attributes->max_length )
				. "' value='" . htmlentities( $attributes->value ) . "'";
		$input .= ( $attributes->required ) ? ' required' : '';
		$input .= " /></div>" . PHP_EOL;
		if( ! empty($this->errors) ){
			// form was submitted and validation errors occurred
			$errormsg = "<ul>";
			foreach ( $this->errors as $error ) {
				$errormsg .= "<li>{$error}</li>";
			}
			$errormsg .= "</ul>";
			return $label . $input . $errormsg;
		}
		return $label . $input;
	}

	/**
	 * Sets the new value for a field
	 * @param $value
	 */
	public function update( $value ) {
		parent::update($value);
		if( ! FormValidator::isAlphaNumeric( $value )){
			$this->addError( 'Only alphanumeric fields allowed' );
		}
		$this->setAttribute( 'value', $value );
	} // end update
} // end FormTextField
