<?php

namespace App\Model;

use App\Model\Entity\Uzivatel;
use App\Model\Repository\UzivatelRepository;
use Nettrine\ORM\EntityManagerDecorator;
use Nette\Security\Passwords;
use \Firebase\JWT\JWT;

class LoginManager
{

    private $uzivatel;

    public function __construct(UzivatelRepository $uzivatel)
    {
        $this->uzivatel = $uzivatel;
    }

    public function authentication($credentials)
    {
        $name = $credentials->uzivatel_jmeno;
        $identity = $this->uzivatel->get_user($name);

        if ($identity) {
            $pass = $identity->getHeslo();
            $activation = $identity->getAktivacni_klic();
            $id = $identity->getId();
            $username = $identity->getUzivatel_jmeno();
        } else {
            return "User not found!";
        }

     
        
        if ($identity && $activation == "activated") {
            $verified = password_verify($credentials->heslo, $pass);
            if($verified){
                $tokens = $this->create_tokens($id, $username);
                $this->set_cookies($tokens);
                return "success";
            }
         }

    }

    public function create_tokens($id, $username)
    {
        $secret_key = $_ENV['SECRET_KEY'];
        $secret_key2 = $_ENV['SECRET_KEY2'];
        $issuer_claim = "THE_ISSUER"; // this can be the servername
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim; //not before in seconds
        $expire_claim = $issuedat_claim + 25000000; // expire time in seconds
        $expire_claim2 = $issuedat_claim + 11;

        $token = array(
                    "iss" => "$issuer_claim",
                    "aud" => $audience_claim,
                    "iat" => $issuedat_claim,
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "id" => $id,
                        "username" => $username,
                    )
                );

        $token2 = array(
                    "iss" => "$issuer_claim",
                    "aud" => $audience_claim,
                    "iat" => $issuedat_claim,
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim2,
                    "data" => array(
                        "id" => $id,
                        "username" => $username,
                    )
                );

        $tokens = array(
                'refresh'=> JWT::encode($token, $secret_key),
                'access' => JWT::encode($token2, $secret_key2),
                );

        return $tokens;         

    }


    // pro deploy nastavit cookies na refresh secure=true, httponly=true, samesite= none, access to same akorat httponly= false
    public function set_cookies($tokens): void
    {
        $refresh = "refreshtoken";
        $access = "accesstoken";

        $refreshToken= $tokens['refresh'];
        $accessToken = $tokens ['access'];

        $cookie_options = array(
            'expires' => time() + 60*60*24*30,
            'path' => '/',
            'domain' => '', // leading dot for compatibility or use subdomain
            'secure' => false, // or false
           // 'httponly' => true, // or false
            //'samesite' => 'None' // None || Lax || Strict
          );

          $cookie_options1 = array(
            'expires' => time() + 11,
            'path' => '/',
            'domain' => '', // leading dot for compatibility or use subdomain
            'secure' => false, // or false
           //'httponly' => false, // or false
          //  'samesite' => 'None' // None || Lax || Strict
          );
          
          setcookie($refresh, $refreshToken, $cookie_options);
          setcookie($access, $accessToken, $cookie_options1);

    }
}
