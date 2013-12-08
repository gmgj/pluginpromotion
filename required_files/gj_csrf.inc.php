<?php
/**
* gj_csrf.inc.php
* Based on https://www.owasp.org/index.php/PHP_CSRF_Guard
*
* @category Session Mgmt
* @package  CRSF token and token to match form to action
* @author   Gary Johnson <gary_johnson_53@hotmail.com>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     http://garyjohnsoninfo.info
*/


/*
The first three functions, are an abstraction over how session variables are stored.
Replace them if you don't use native PHP sessions.

The generate function, creates a random secure one-time CSRF token.
If SHA512 is available, it is used, otherwise a 512 bit random string in the same format is generated.
This function also stores the generated token under a unique name in session variable.

The validate function, checks under the unique name for the token. There are three states:

    Removed Sessions not active: validate succeeds (no CSRF risk)
    Token found but not the same, or token not found: validation fails
    Token found and the same: validation succeeds

Either case, this function removes the token from sessions, ensuring one-timeness.

*/


function store_in_session($key,$value)
{
	if (isset($_SESSION)) {
		$_SESSION[$key]=$value;
	}
}

function unset_session($key)
{
	$_SESSION[$key]=' ';
	unset($_SESSION[$key]);
}

function get_from_session($key)
{
	if (isset($_SESSION)) {
		return $_SESSION[$key];
	} else {
        return false;
    }
}

function csrfguard_generate_token($unique_form_name)
{
	if (function_exists("hash_algos") and in_array("sha512",hash_algos())){
		$token=hash("sha512",mt_rand(0,mt_getrandmax()));
	} else {
		$token=' ';
		for ($i=0;$i<128;++$i) {
			$r=mt_rand(0,35);
			if ($r<26) {
				$c=chr(ord('a')+$r);
			} else {
				$c=chr(ord('0')+$r-26);
			}
			$token.=$c;
		}
	}
	store_in_session($unique_form_name,$token);
	return $token;
}

function csrfguard_validate_token($unique_form_name,$token_value)
{
	$token=get_from_session($unique_form_name);
	if ($token===false) {
		return false;
	} 	elseif ($token===$token_value) {
		$result=true;
	} else {
		$result=false;
	}
	unset_session($unique_form_name);
	return $result;
}

