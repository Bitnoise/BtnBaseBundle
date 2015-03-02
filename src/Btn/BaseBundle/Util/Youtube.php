<?php

namespace Btn\BaseBundle\Util;

class Youtube
{
    const URL_REGEXP = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
    const ID_REGEXP = '%^[^"&?/ ]{11}$%i';

    /**
     *
     */
    public static function getVideoIdFromUrl($url)
    {
        if (preg_match(self::URL_REGEXP, $url, $match)) {
            return $match[1];
        }
    }

    /**
     *
     */
    public static function isValidUrl($url)
    {
        return preg_match(self::URL_REGEXP, $url) ? true : false;
    }

    /**
     *
     */
    public static function isValidId($id) 
    {
        return preg_match(self::ID_REGEXP, $id) ? true : false;
    }

    /**
     *
     */
    public static function getVideoId($input) 
    {
        if (self::isValidUrl($input)) {
            return self::getVideoIdFromUrl($input);
        } elseif (self::isValidId($input)) {
            return $input;
        }
    }
}