<?php 

namespace App\Presenters;


use Nette;
use Nette\Application\UI\Presenter;
use App\Model\RegisterManager;

class RegisterPresenter extends Presenter {

    private $reg_manager;

    public function __construct(RegisterManager $register)
    {
        $this->reg_manager = $register;
    }
    
    public function actionRegister(){

        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: POST");

        $result=$this->reg_manager->register($_POST);
        
        $this->sendJson($result);
        
       
    }

}