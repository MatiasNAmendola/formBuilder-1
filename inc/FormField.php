<?php
/**
 * Created by JetBrains PhpStorm.
 * User: paul
 * Date: 23/02/13
 * Time: 15:36
 * To change this template use File | Settings | File Templates.
 */
abstract class FormField {

	/**
	 * The list of field attributes
	 * @var array
	 */
	protected $attributes;

	protected $group;

	public $errors;

	/**
	 * Functions that should be implemented by child classes
	 */
	abstract protected function render();

	/**
	 * Checks for required field
	 * @param $value
	 */
	public function update( $value ){
		if ( empty( $value ) && $this->attributes['required'] ) {
			$this->addError( 'Field cannot be empty' );
		}
	}

	/**
	 * Creates a new instance of the FormField class
	 * @param Form  $form
	 * @param array $attributes
	 * @param bool  $required
	 */
	public function __construct( Form $form, array $attributes, $required = false ) {
		foreach($attributes as $key => $value){
			$this->setAttribute($key, $value);
		}
		$this->sanitizeAttributes();
		$this->setAttribute('required', (bool) $required);
		$this->addToForm( $form );
	}

	/**
	 * Add this field to the form
	 * @param $form
	 */
	public function addToForm( $form ){
		$form->addField($this);
		$this->group = $form->getGroup();
	}

	/**
	 * Neutralizes any harmful input in attribute values
	 */
	public function sanitizeAttributes() {
		// run each field attribute value through a security filter because we don't trust user input
		foreach ( $this->attributes as $key => $value ) {
			$this->attributes[$key] = filter_var( $value, FILTER_SANITIZE_STRING );
		}

	}

	/**
	 * Sets the value attribute of a Form Field
	 * @param $attr_key
	 * @param $newValue
	 */
	public function setAttribute( $attr_key, $newValue ) {
		if($this->attributes[$attr_key] != $newValue)
			$this->attributes[$attr_key] =   $newValue;
	}

	/**
	 * Gets a field attribute by key
	 * @param $attr_name
	 * @return mixed
	 */
	public function getAttribute( $attr_name ){
		return  $this->attributes[$attr_name];
	}

	/**
	 * Displays Field as HTML
	 * @return mixed
	 */
	public function __toString() {
		return $this->render();
	}

	/**
	 * Adds an error to the field
	 * @param string $error
	 */
	public function addError( $error ){
		$this->errors[] = $error;
	}

	/**
	 * Get the field's errors
	 * @return mixed
	 */
	public function getErrors(){
	return $this->errors;
}
}
