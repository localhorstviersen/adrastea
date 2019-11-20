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
        $controllers = explode(',', env('ldap.host'));

        $config = [
            'account_suffix' => env('ldap.accountSuffix'),
            'domain_controllers' => $controllers,
            'base_dn' => env('ldap.baseDn')
        ];
        $this->resource = new Adldap($config);
    }

    public function checkCredentials(string $mail, string $password): bool
    {
        $mailExplode = explode('@', $mail);

        try {
            if ((count($mailExplode) === 2) && $this->resource->authenticate($mailExplode[0], $password)) {
                return true;
            }
        } catch (Exception $exception) {
            return false;
        }

        return false;
    }

    public function getUserInfo(string $mail, string $password)
    {
        $mailExplode = explode('@', $mail);

        try {
            if ((count($mailExplode) === 2)) {
                $this->resource->authenticate($mailExplode[0], $password);
                $info = $this->resource->user()->find('lrisse');
                var_dump($this->resource->getLastError());
                return null;
            }
        } catch (Exception $exception) {
            return null;
        }

        return null;
    }

    /**
     * @return Adldap
     */
    public function getResource(): Adldap
    {
        return $this->resource;
    }
}