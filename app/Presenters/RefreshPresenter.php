<?php 

namespace App\Presenters;

use \Firebase\JWT\JWT;
use \Exception;
use Nette;
use Nette\Application\UI\Presenter;
use App\Model\Repository\UzivatelRepository;


class RefreshPresenter extends Presenter {

    private $uzivatel;
    public function __construct(UzivatelRepository $uzivatel)
    {
        $this->uzivatel= $uzivatel;
    }

   
    public function actionRefresh(){
        

        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: POST");
        header('Access-Control-Allow-Credentials: true');
        $valid = true;
        if (!isset($_COOKIE["refreshtoken"])) {
            return $valid = false;
        }


        try {
            $key = $_ENV['SECRET_KEY'];
            $token = $_COOKIE["refreshtoken"];
            $data = JWT::decode($token, $key, array('HS256'));
            $valid = true;
        } catch (Exception $e) { // Also tried JwtException

            $valid = false;
        }

        if ($valid) {
            $result = $this->uzivatel->get_user_by_id($data->data->id);

            $secret_key2 = $_ENV['SECRET_KEY2'];
            $issuer_claim = "THE_ISSUER"; // this can be the servername
            $audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim; //not before in seconds
            $expire_claim = $issuedat_claim + 25000000; // expire time in seconds
            $expire_claim2 = $issuedat_claim + 11;

            $token2 = array(
                "iss" => "$issuer_claim",
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim2,
                "data" => array(
                    "id" => $result->getId(),
                    "username" => $result->getUzivatel_jmeno(),
                )
            );

            $accessToken = JWT::encode($token2, $secret_key2);

            $cookie_options1 = array(
                'expires' => time() + 11,
                'path' => '/',
                'domain' => '', // leading dot for compatibility or use subdomain
                'secure' => false, // or false
             //   'httponly' => false, // or false
                //'samesite' => 'None' // None || Lax || Strict
            );

            setcookie('accesstoken', $accessToken, $cookie_options1);
            $this->sendJson(" ");
        }
      
        
       
    }

}