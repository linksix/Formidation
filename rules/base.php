<?php
	/**
	 * Champ requis. Vérifie simplement si la chaîne du champ est vide ou non.
	 * @param string $value
	 * @return bool
	 */
	function required($value)
	{
		if ( ! is_array($value))
		{
			return (trim($value) == '') ? FALSE : TRUE;
		}
		else
		{
			return ( ! empty($value));
		}
	}

	/**
	 * Vérifie l'expression régulière donnée.
	 * @param string $value
	 * @param string $regex
	 * @return bool
	 */
	function regex_match($value, $regex)
	{
		if ( ! preg_match($regex, $value))
		{
			return FALSE;
		}

		return  TRUE;
	}

	/**
	 * Longueur minimale
	 * @param	string $value
	 * @param	string $length
	 * @return	bool
	 */
	function min_length($value, $length)
	{
		if (preg_match("/[^0-9]/", $length))
		{
			return FALSE;
		}

		if (function_exists('mb_strlen'))
		{
			return (mb_strlen($value) < $length) ? FALSE : TRUE;
		}

		return (strlen($value) < $length) ? FALSE : TRUE;
	}

	/**
	 * Longueur maximale
	 * @param	string $value
	 * @param	string $length
	 * @return	bool
	 */
	function max_length($value, $length)
	{
		if (preg_match("/[^0-9]/", $length))
		{
			return FALSE;
		}

		if (function_exists('mb_strlen'))
		{
			return (mb_strlen($value) > $length) ? FALSE : TRUE;
		}

		return (strlen($value) > $length) ? FALSE : TRUE;
	}

	/**
	 * Longueur exacte
	 * @param	string $value
	 * @param	string $length
	 * @return	bool
	 */
	function exact_length($value, $length)
	{
		if (preg_match("/[^0-9]/", $length))
		{
			return FALSE;
		}

		if (function_exists('mb_strlen'))
		{
			return (mb_strlen($value) != $length) ? FALSE : TRUE;
		}

		return (strlen($value) != $length) ? FALSE : TRUE;
	}

	/**
	 * Email valide
	 * @param	string $email
	 * @return	bool
	 */
	function valid_email($email)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
	}

	/**
	 * Plusieurs emails valides.
	 * @param	string $emails Emails séparés par des virgules
	 * @return	bool
	 */
	function valid_emails($emails)
	{
		if (strpos($emails, ',') === FALSE)
		{
			return $this->valid_email(trim($emails));
		}

		foreach (explode(',', $emails) as $email)
		{
			if (trim($email) != '' && $this->valid_email(trim($email)) === FALSE)
			{
				return FALSE;
			}
		}

		return TRUE;
	}

	/**
	 * Adresse IP valide.
	 * @param	string $ip
	 * @param	string $version "ipv4" ou "ipv6"
	 * @return	string
	 */
	function valid_ip($ip, $version = '')
	{
		$version = strtolower($version);

        switch ($version) {
            case 'ipv4':
                $flag = FILTER_FLAG_IPV4;
                break;
            case 'ipv6':
                $flag = FILTER_FLAG_IPV6;
                break;
            default:
                $flag = '';
                break;
        }

        return (bool) filter_var($ip, FILTER_VALIDATE_IP, $flag);
	}

	/**
	 * Alpha
	 * @param	string $value
	 * @return	bool
	 */
	function alpha($value)
	{
		return ( ! preg_match("/^([a-z])+$/i", $value)) ? FALSE : TRUE;
	}

	/**
	 * Alpha-numerique
	 * @param	string $value
	 * @return	bool
	 */
	function alpha_numeric($value)
	{
		return ( ! preg_match("/^([a-z0-9])+$/i", $value)) ? FALSE : TRUE;
	}

	/**
	 * Alpha-numerique avec tirets et underscores
	 * @param	string $value
	 * @return	bool
	 */
	function alpha_dash($value)
	{
		return ( ! preg_match("/^([-a-z0-9_-])+$/i", $value)) ? FALSE : TRUE;
	}

	/**
	 * Numeric
	 * @param	string $value
	 * @return	bool
	 */
	function numeric($value)
	{
		return (bool)preg_match( '/^[\-+]?[0-9]*\.?[0-9]+$/', $value);

	}

	/**
	 * Entier
	 * @param	string $value
	 * @return	bool
	 */
	function integer($value)
	{
		return (bool) preg_match('/^[\-+]?[0-9]+$/', $value);
	}

	/**
	 * Nombre décimal
	 * @param	string $value
	 * @return	bool
	 */
	function decimal($value)
	{
		return (bool) preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $value);
	}

	/**
	 * Nombre plus grand que
	 * @param	string $value
     * @param   string $min
	 * @return	bool
	 */
	function greater_than($value, $min)
	{
		if ( ! is_numeric($value))
		{
			return FALSE;
		}
		return $value > $min;
	}

	/**
	 * Moins grand que
	 * @param	string $value
	 * @return	bool
	 */
	function less_than($value, $max)
	{
		if ( ! is_numeric($value))
		{
			return FALSE;
		}
		return $value < $max;
	}

	/**
	 * Est un nombre naturel  (0,1,2,3, etc.)
	 * @param	string $value
	 * @return	bool
	 */
	function is_natural($value)
	{
		return (bool) preg_match( '/^[0-9]+$/', $value);
	}

	/**
	 * Est un nombre naturel, sauf zéro (1,2,3, etc.)
	 * @param	string $value
	 * @return	bool
	 */
	function is_natural_no_zero($value)
	{
		if ( ! preg_match( '/^[0-9]+$/', $value))
		{
			return FALSE;
		}

		if ($value == 0)
		{
			return FALSE;
		}

		return TRUE;
	}

	/**
     * Regarde si la chaîne donnée contient des caractères en dehors
     * de l'alphabet Base64, tel que défini dans la RFC 2045
     * http://www.faqs.org/rfcs/rfc2045
	 * @param	string $value
	 * @return	bool
	 */
	function valid_base64($value)
	{
		return (bool) ! preg_match('/[^a-zA-Z0-9\/\+=]/', $value);
	}
