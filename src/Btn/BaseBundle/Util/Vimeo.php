<?php

namespace Btn\BaseBundle\Util;

class Vimeo
{
    const URL_REGEXP = '%^https?://(player\.)?vimeo\.com(/video)?/(\d{9})%i';
    const ID_REGEXP = '%^\d{9}$%';

    /**
     * @param $url
     *
     * @return
     */
    public static function getVideoIdFromUrl($url)
    {
        if (preg_match(self::URL_REGEXP, $url, $match)) {
            return $match[3];
        }
    }

    /**
     * @param $url
     *
     * @return bool
     */
    public static function isValidUrl($url)
    {
        return preg_match(self::URL_REGEXP, $url) ? true : false;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public static function isValidId($id)
    {
        return preg_match(self::ID_REGEXP, $id) ? true : false;
    }

    /**
     * @param string $input
     *
     * @return string
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
