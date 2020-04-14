<?php


namespace App\Libraries;

use CodeIgniter\I18n\Time;

/**
 * Class Util
 *
 * @package App\Libraries
 */
class Util
{
    /**
     * This method will format a date string of the database in the correct format.
     *
     * @param string $dateString
     *
     * @return string
     * @throws \Exception
     */
    public static function formatDateTime(string $dateString): string
    {
        return Time::createFromFormat('Y-m-d H:i:s', $dateString)->format('d.m.Y H:i:s');
    }
}