<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Presenter;

use App\Model\LoginManager;

class LoginPresenter extends Presenter
{

    private $loginManager;

    public function __construct(LoginManager $loginManager)
    {
        $this->loginManager = $loginManager;
    }

    public function actionLogin()
    {

        header("Access-Control-Allow-Origin: http://localhost:3000");
        header('Access-Control-Allow-Credentials: true');
        $credentials = json_decode(file_get_contents("php://input"));
        $httpResponse = $this->getHttpResponse();

        $res = $this->loginManager->authentication($credentials);
        
        if ($res == "success") {
            $this->sendJson($res);
        }else {
            $httpResponse->setCode(Nette\Http\Response::S401_UNAUTHORIZED);
        }
    }
}
