<?php

/**
 * Created by PhpStorm.
 * User: RaZoR
 * Date: 9/16/2016
 */
namespace inc\Base;
class Validator
{
    /**
     * Checks if the given value is empty
     * @param mixed $value
     * @return boolean whether the value is empty
     */
    public static function isEmpty($value)
    {
        return $value === null || $value === array() || $value === '' || trim($value) === '';
    }

    public static function isInternetProtocol($ip)
    {
        $isValid = filter_var($ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV4);
        if($isValid){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Checks if the given value is an alphabetic value
     * @param mixed $value
     * @return boolean
     */
    public static function isAlpha($value)
    {
        return ctype_alpha($value);
    }

    /**
     * Checks if the given value is a numeric value
     * @param mixed $value
     * @return boolean
     */
    public static function isNumeric($value)
    {
        return preg_match('/^[0-9]+$/', $value);
    }

    /**
     * Checks if the given value is a alpha-numeric value
     * @param mixed $value
     * @return boolean
     */
    public static function isAlphaNumeric($value)
    {
        return preg_match('/^[a-zA-Z0-9]+$/', $value);
    }

    /**
     * Checks if the given value is a variable name in PHP
     * @param mixed $value
     * @return boolean
     */
    public static function isVariable($value)
    {
        return preg_match('/^[a-zA-Z]+[0-9a-zA-Z_]*$/', $value);
    }

    /**
     * Checks if the given value is a alpha-numeric value and spaces
     * @param mixed $value
     * @return boolean
     */
    public static function isMixed($value)
    {
        return preg_match('/^[A-Za-z0-9_]+$/u', $value);
    }

    /**
     * Checks if the given value is a textual value and allowed HTML tags
     * @param mixed $value
     * @return boolean
     */
    public static function isText($value)
    {
        if((preg_match("/<[^>]*script*\"?[^>]*>/i", $value)) ||
            (preg_match("/<[^>]*object*\"?[^>]*>/i", $value)) ||
            (preg_match("/<[^>]*iframe*\"?[^>]*>/i", $value)) ||
            (preg_match("/<[^>]*applet*\"?[^>]*>/i", $value)) ||
            (preg_match("/<[^>]*meta*\"?[^>]*>/i", $value)) ||
            (preg_match("/<[^>]*style*\"?[^>]*>/i", $value)) ||
            (preg_match("/<[^>]*form*\"?[^>]*>/i", $value)) ||
            (preg_match("/<[^>]*img*\"?[^>]*>/i", $value)) ||
            (preg_match("/<[^>]*onmouseover*\"?[^>]*>/i", $value)) ||
            (preg_match("/<[^>]*body*\"?[^>]*>/i", $value)) ||
            (preg_match("/\([^>]*\"?[^)]*\)/i", $value)) ||
            (preg_match("/ftp:\/\//i", $value)) ||
            (preg_match("/https:\/\//i", $value)) ||
            (preg_match("/http:\/\//i", $value)) )
        {
            return false;
        }
        return true;
    }

    /**
     * Checks if the given value is a phone number
     * @param mixed $value
     * @return boolean
     */
    public static function isPhone($value)
    {
        return preg_match('/^[\d]{3}[-]{1}[\d]{3}[-]{1}[\d]{4}$/', $value);
    }
    /**
     * Checks if the given value is a birthday
     * @param mixed $value
     * @return boolean
     */
    public static function isBirthday($value)
    {
        return preg_match('/^[\d]{4}[-]{1}[\d]{2}[-]{1}[\d]{2}$/', $value);
    }

    /**
     * Checks if the given value is a password
     * @param mixed $value
     * @return boolean
     */
    public static function isPassword($value)
    {
        return preg_match('/^[a-zA-Z0-9_\-!@#$%^&*()]{6,20}$/', $value);
    }

    /**
     * Checks if the given value is a username
     * @param mixed $value
     * @return boolean
     */
    public static function isUsername($value)
    {
        if(preg_match('/^[a-zA-Z0-9_\-]{3,20}$/', $value) && !self::isNumeric($value))
        {
            return true;
        }

        return false;
    }

    /**
     * Checks if the given value is a file name
     * @param mixed $value
     * @return boolean
     */
    public static function isFileName($value)
    {
        return preg_match('/^[a-zA-Z0-9_\-]+$/', $value);
    }

    /**
     * Checks if the given value is an email
     * @param mixed $value
     * @return boolean
     */
    public static function isEmail($value)
    {
        return preg_match('/^[\w-]+(?:\.[\w-]+)*@(?:[\w-]+\.)+[a-zA-Z]{2,7}$/', $value);
    }

    /**
     * Checks if the given value is a date value
     * @param mixed $value
     * @return boolean
     */
    public static function isDate($value)
    {
        return self::isNumeric(strtotime($value));
    }

    /**
     * Checks if the given value is a digit value
     * @param mixed $value
     * @return boolean
     */
    public static function isDigit($value)
    {
        return ctype_digit($value);
    }

    /**
     * Checks if the given value is an integer value
     * @param mixed $value
     * @return boolean
     */
    public static function isInteger($value)
    {
        return preg_match('/^[0-9]+$/', $value);
    }

    /**
     * Checks if the given value is a float value
     * @param mixed $value
     * @return boolean
     */
    public static function isFloat($value)
    {
        return is_float($value);
    }

    /**
     * Checks if the given value is a valid URL address
     * @param mixed $value
     * @return boolean
     */
    public static function isUrl($value)
    {
        return (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $value)) ? false : true;
    }

    /**
     * Validates the length of the given value
     * @param string $value
     * @param int $min
     * @param int $max
     * @return boolean
     */
    public static function validateLength($value, $min, $max)
    {
        $length = strlen($value);
        return ($length >= $min && $length <= $max);
    }

    /**
     * Validates the minimum length of the given value
     * @param string $value
     * @param int $min
     * @return boolean
     */
    public static function validateMinlength($value, $min)
    {
        return (strlen($value) < $min) ? false : true;
    }

    /**
     * Validates the maximum length of the given value
     * @param string $value
     * @param int $max
     * @return boolean
     */
    public static function validateMaxlength($value, $max)
    {
        return (strlen($value) > $max) ? false : true;
    }

    public static function isJson($json, $assoc_array = false)
    {
        json_decode($json, $assoc_array);

        switch(json_last_error())
        {
            case JSON_ERROR_NONE:
                $error = false;
                break;
            case JSON_ERROR_DEPTH:
                $error = 'Maximum stack depth exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Underflow or the modes mismatch.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Unexpected control character found.';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON.';
                break;
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
            default:
                $error = 'Unknown JSON error occured.';
                break;
        }

        return ($error === false) ? true : $error;
    }

    /**
     * Validates value as IP address
     * @param mixed $value
     * @return boolean
     */
    public static function isIP($value)
    {
        return (!filter_var($value, FILTER_VALIDATE_IP)) ? false : true;
    }

    /**
     * Checks if the given value is valid md5
     * @param mixed $value
     * @return boolean
     */
    public static function isValidMd5($value)
    {
        return (strlen($value) == 32 and ctype_xdigit($value));
    }

    /**
     * Checks if the given value is hex color string
     * @param mixed $value
     * @param bool $hash
     * @return boolean
     */
    public static function isHexColor($value, $hash = true)
    {
        return ($hash===true ? preg_match('/^#[a-f0-9]{6}$/i', $value) : preg_match('/^[a-f0-9]{6}$/i', $value));
    }

    /**
     * Checks if the given value presents in a given array
     * @param mixed $value
     * @param array $array
     * @return boolean
     */
    public static function inArray($value, $array = array())
    {
        if(!is_array($array)) return false;
        return in_array($value, $array);
    }

    /**
     * Validates if the given numeric value in a specified range
     * @param string $value
     * @param integer $min
     * @param integer $max
     * @return boolean
     */
    public static function validateRange($value, $min, $max)
    {
        if(!is_numeric($value)) return false;
        return ($value >= $min && $value <= $max) ? true : false;
    }

    /**
     * Validates if the given numeric value in a specified range
     * @param string $value
     * @return boolean
     */
    public static function cleanString($value)
    {
        $charset = 'UTF-8';
        if($charset == 'UTF-8'){
            return preg_replace('/[^a-zа-яё]+/iu', '', $value);
        }else{
            return preg_replace('/[^a-zа-яё]+/i', '', $value);
        }
    }

    /**
     * Detect character encoding
     * @param $str
     * @param null $encoding_list
     * @param bool $strict
     * @return string
     */
    public static function detectEncoding($str, $encoding_list = null, $strict = true)
    {
        return mb_detect_encoding($str, $encoding_list, $strict);
    }
}