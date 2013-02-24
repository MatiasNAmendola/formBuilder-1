<?php
/**
 * Created by JetBrains PhpStorm.
 * User: paul
 * Date: 24/02/13
 * Time: 16:36
 * To change this template use File | Settings | File Templates.
 */
class FormValidator {

	public static function isAlphaNumeric( $value ) {
		return ctype_alnum( $value );
	}

	public static function isEmailAddress( $value ) {
		return filter_var( $value, FILTER_VALIDATE_EMAIL );
	}
}
