<?php
	/**
	 * Convertit les tags php en entités HTML.
	 * @param	string $value
	 * @return	string $encoded_value
	 */
	function encode_php_tags($value)
	{
		return str_replace(array('<?php', '<?PHP', '<?', '?>'),  array('&lt;?php', '&lt;?PHP', '&lt;?', '?&gt;'), $value);
	}
