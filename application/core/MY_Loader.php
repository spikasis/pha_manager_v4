<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {
	
	/**
	 * Object to Array
	 *
	 * Takes an object as parameter and converts it to an array.
	 * This method was removed in newer CodeIgniter versions but is needed for HMVC compatibility.
	 *
	 * @param	mixed	$object
	 * @return	array
	 */
	protected function _ci_object_to_array($object)
	{
		if ( ! is_object($object))
		{
			return $object;
		}
		
		if (is_object($object))
		{
			if (method_exists($object, 'to_array'))
			{
				return $object->to_array();
			}
			else
			{
				return get_object_vars($object);
			}
		}
		
		return (array) $object;
	}
}