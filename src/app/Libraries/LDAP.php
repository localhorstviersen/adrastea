<?php


namespace App\Libraries;

use Adldap\Adldap;
use Adldap\Auth\BindException;
use Adldap\Connections\Provider;
use Adldap\Exceptions\AdldapException;
use Adldap\Models\Group;
use Adldap\Models\User;
use App\Models\DTO\GroupData;
use App\Models\DTO\UserData;

/**
 * Class LDAP
 *
 * @package App\Helpers
 * @author  Lars Riße <me@elyday.net>
 */
class LDAP
{
    /**
     * @var Adldap $adldap
     */
    private $adldap;

    /**
     * @var Provider $provider
     */
    private $provider;

    public function __construct()
    {
        $this->adldap = new Adldap();
        $controllers = explode(',', env('ldap.host'));
        $config = [
            'hosts' => $controllers,
            'base_dn' => env('ldap.base.dn'),
            'account_suffix' => env('ldap.suffix')
        ];
        $this->adldap->addProvider($config);
    }

    public function checkCredentials(string $username, string $password): bool
    {
        try {
            $this->provider = $this->adldap->connect('default', $username . env('ldap.suffix'), $password);
            return true;
        } catch (BindException $exception) {
            return false;
        }
    }

    /**
     * @param string $username
     *
     * @return UserData|null
     */
    public function getUserData(string $username): ?UserData
    {
        /** @var User $entry */
        $entry = $this->provider->search()->users()->find($username);

        if ($entry instanceof User) {
            $userData = new UserData();
            $userData->sId = $this->sIdToString($entry->getObjectSid());
            $userData->username = $entry->getUserPrincipalName();
            $userData->firstName = $entry->getFirstName();
            $userData->surname = $entry->getLastName();
            $userData->mail = $entry->getEmail();

            /** @var Group $group */
            foreach ($entry->getGroups() as $group) {
                $groupData = new GroupData();
                $groupData->sID = $this->sIdToString($group->getObjectSid());
                $groupData->name = $group->getName();
                $userData->groups[] = $groupData;
            }

            return $userData;
        }
        return null;
    }

    /**
     * @return Adldap
     */
    public function getAdldap(): Adldap
    {
        return $this->adldap;
    }

    /**
     * This method will convert a binary to a string
     *
     * @param $string
     *
     * @return string
     */
    private function sIdToString($string): string
    {
        $hex = bin2hex($string);
        $rev = hexdec(substr($hex, 0, 2));
        $subCount = hexdec(substr($hex, 2, 2));
        $auth = hexdec(substr($hex, 4, 12));
        $result = $rev . '-' . $auth;

        for ($i = 0; $i < $subCount; $i++) {
            $subStr = substr($hex, 16 + ($i * 8), 8);

            $str = '';
            for ($x = strlen($subStr) - 2; $x >= 0; $x -= 2) {
                $str .= substr($subStr, $x, 2);
            }

            $subAuth[$i] = hexdec($str);
            $result .= '-' . $subAuth[$i];
        }

        return 'S-' . $result;
    }
}