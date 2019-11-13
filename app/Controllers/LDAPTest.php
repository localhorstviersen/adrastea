<?php


namespace App\Controllers;


use App\Libraries\LDAP;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class LDAPTest extends CoreController
{
    /**
     * @var LDAP
     */
    private $ldap;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->ldap = new LDAP();
    }

    public function index()
    {
        ldap_bind($this->ldap->getResource(), '', '');
        $search = ldap_search($this->ldap->getResource(), 'OU=Benutzer,DC=RKW,DC=rkw-viersen,DC=de', '(userprincipalname=lrisse@rkw.rkw-viersen.de)');
        $entries = ldap_get_entries($this->ldap->getResource(), $search);

        var_dump(utf8_encode($entries[0]['displayname'][0]));

        //$entry = ldap_get_values_len($ldap, ldap_first_entry($ldap, $search), 'objectsid');
        //echo $this->bin_to_str_sid($entry[0]);
    }

    private function bin_to_str_sid($binsid): string
    {
        $hex_sid = bin2hex($binsid);
        $rev = hexdec(substr($hex_sid, 0, 2));
        $subcount = hexdec(substr($hex_sid, 2, 2));
        $auth = hexdec(substr($hex_sid, 4, 12));
        $result = "$rev-$auth";

        for ($x = 0; $x < $subcount; $x++) {
            $subauth[$x] =
                hexdec($this->little_endian(substr($hex_sid, 16 + ($x * 8), 8)));
            $result .= "-" . $subauth[$x];
        }

        // Cheat by tacking on the S-
        return 'S-' . $result;
    }

    private function little_endian($hex): string
    {
        $result = '';
        for ($x = strlen($hex) - 2; $x >= 0; $x = $x - 2) {
            $result .= substr($hex, $x, 2);
        }
        return $result;
    }
}