<?php


namespace App\Libraries;

/**
 * Class LDAP
 * @package App\Helpers
 */
class LDAP
{
    /**
     * @var null|resource $resource
     */
    private $resource = null;

    public function __construct()
    {
        $resource = ldap_connect('ldap://' . env('ldap.host'));
        $this->resource = $resource ?: null;
    }

    /**
     * @return resource|null
     */
    public function getResource()
    {
        return $this->resource;
    }
}