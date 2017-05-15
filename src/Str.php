<?php

namespace Lagan\Property;

use Sirius\Validation\Validator;

/**
 * Controller for the Lagan string property.
 * Uses the Siriusphp validation library to validate strings.
 *
 * A property type controller can contain a set, read, delete and options method. All methods are optional.
 * To be used with Lagan: https://github.com/lutsen/lagan
 */

class Str {

	/**
	 * The set method is executed each time a property with this type is set.
	 *
	 * @param bean		$bean		The Redbean bean object with the property.
	 * @param array		$property	Lagan model property arrray.
	 * @param string	$new_value	The input string of this property.
	 *
	 * @return string	The validated string.
	 */
	public function set($bean, $property, $new_value) {

		if ( isset( $property['validate'] ) ) {

			$validator = new Validator();
			$validator->add( [ $property['name'] => $property['validate'] ] ); // Validator rule(s) need to be an array

			if ( $validator->validate( [ $property['name'] => $new_value ] ) ) { // Validator needs an array as input
				return $new_value;
			} else {
				$messages = $validator->getMessages();
				throw new \Exception( $property['description'].' validation error. ' . implode( ', ', $messages[ $property['name'] ] ) );
			}

		} else {
			return $new_value;
		}

	}

}

?>