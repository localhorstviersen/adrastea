<?php


namespace App\Libraries;

use Adldap\Adldap;
use Exception;

/**
 * Class LDAP
 * @package App\Helpers
 */
class LDAP
{
    /**
     * @var Adldap $resource
     */
    private $resource;

    public function __construct()
    {
        $config = [
            'account_suffix' => env('ldap.accountSuffix'),
            'domain_controllers' => array(env('ldap.host')),
            'base_dn' => env('ldap.baseDn')
        ];
        $this->resource = new Adldap($config);
    }

    public function checkCredentials(string $mail, string $password): bool
    {
        $mailExplode = explode('@', $mail);

        try {
            if (count($mailExplode) === 2) {
                $mail = $mailExplode[0];

                if ($this->resource->authenticate($mail, $password)) {
                    return true;
                }
            }
        } catch (Exception $exception) {
            return false;
        }

        return false;
    }

    /**
     * @return Adldap
     */
    public function getResource(): Adldap
    {
        return $this->resource;
    }
}