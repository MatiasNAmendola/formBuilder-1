<?php
/**
 * Created by JetBrains PhpStorm.
 * User: paul
 * Date: 23/02/13
 * Time: 14:21
 * To change this template use File | Settings | File Templates.
 */

require_once 'inc/Form.php';

$group = 'data';

// instantiate an new form object
$my_form = new Form( array(
	'group'  => $group,
	'action' => '#',
	'method' => 'POST',
	'value'  => 'Send' // the submit button text
) );

//create a text input field
$first_name = new FormTextField( $my_form,
	array(
		'label'       => 'First Name',
		'name'        => 'first_name',
		'size'        => 50,
		'max_length'  => 255,
		'placeholder' => 'Enter First Name'
	), true
);

//create a text input field
$last_name = new FormTextField( $my_form,
	array(
		'label'       => 'Last Name',
		'name'        => 'last_name',
		'size'        => 50,
		'max_length'  => 255,
		'placeholder' => 'Enter Last Name'
	)
);

//create a text input field
$email_address = new FormEmailField( $my_form,
	array(
		'label'       => 'Email Address',
		'name'        => 'email_address',
		'size'        => 50,
		'max_length'  => 255,
		'placeholder' => 'bob@bob.com'
	), true
);

$search_field = new FormSearchField(
	$my_form,
	array(
		'label' => 'Search whiskies',
		'name' => 'search',
		'size' => 50,
		'maxlength' => 255,
		'placeholder' => 'whisky brand'
	)
);

if($_POST[$my_form->getGroup()]){
	$my_form->submit($_POST[$my_form->getGroup()]);
	if($my_form->hasErrors()){
		echo $my_form;
	} else {
		var_dump($my_form);
	}
} else {
	echo $my_form;
}




