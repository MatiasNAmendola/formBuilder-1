<?php
/**
 * Created by JetBrains PhpStorm.
 * User: paul
 * Date: 23/02/13
 * Time: 20:58
 * To change this template use File | Settings | File Templates.
 */

require_once 'FormField.php';
require_once 'FormTextField.php';
require_once 'FormEmailField.php';
require_once 'FormSearchField.php';
require_once 'FormValidator.php';

class Form {

	/**
	 * The form HTML
	 * @var string
	 */
	protected $html;

	/**
	 * The form action
	 * @var string
	 */
	protected $action;

	/**
	 * The form method (GET or POST)
	 * @var string
	 */
	protected $method;

	/**
	 * The collection of form fields
	 * @var array
	 */
	protected $fields;

	/**
	 * The list of form fields errors
	 * @var array
	 */
	protected $errors;

	protected $group;

	/**
	 * Creates a new instance of the Form class
	 *
	 * @param $args
	 */
	public function __construct( $args ) {
		$this->action = $args['action'];
		$this->method = $args['method'];
		$this->value  = $args['value'];
		$this->group  = $args['group'];
	}

	/**
	 * Creates the entire form HTML markup and saves it to the form property
	 */
	public function buildForm() {
		$this->openForm();
		foreach ( $this->fields as $field ) {
			$this->html .= $field->render();
		}
		$this->closeForm();
	}

	/**
	 * Displays the form in the calling script
	 */
	public function render() {
		$this->buildForm();
		return $this->html;
	}

	/**
	 * Adds a form field to the Form's field array
	 *
	 * @param FormField $field
	 */
	public function addField( FormField $field ) {
		$this->fields[$field->getAttribute( 'name' )] = $field;
	}

	/**
	 * Generates the opening form tag with the action and method
	 * and adds it to the form property
	 */
	public function openForm() {
		$this->html = "<form action='{$this->action}' method='{$this->method}'>" . PHP_EOL;
	}

	/**
	 * Closes the form HTML tag
	 */
	public function closeForm() {
		$this->html .= "<div><input type='submit' value='{$this->value}'/></div>" . PHP_EOL;
		$this->html .= "</form>" . PHP_EOL;
	}

	/**
	 * Gets the form HTML, so you can echo the form object
	 * @return string
	 */
	public function __toString() {
		return $this->render();
	}

	/**
	 * Check for form validation errors
	 * @return bool
	 */
	public function hasErrors() {
		if ( ! empty( $this->errors ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Provides a way to display the form fields validation errors
	 * @return array
	 */
	public function displayErrors() {
		return $this->errors;
	}

	/**
	 * Get the form's fields
	 * @return array
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Process the user data
	 * @param $formData
	 */
	public function submit( $formData ) {
			// Retrieve our form fields
			$fields = $this->getFields();
			// loop through the user input data and for each value, find the field by key
			// and assign the user data to the field value
			foreach ( $formData as $key => $value ) {
				// if there is a field with that ID, then update its value attribute
				if ( $fields[$key] ) {
					$fields[$key]->update( $value );
					if($fields[$key]->getErrors())
						$this->errors[] = $fields[$key]->getErrors();
				}
			} // end foreach
	} // end saveData

	/**
	 * Returns the name of the form's field values array
	 * @return mixed
	 */
	public function getGroup() {
		return $this->group;
	}
}
