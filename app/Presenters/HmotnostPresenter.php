<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Presenter;

use App\Model\Authorization;
use App\Model\Repository\StajRepository;
use App\Model\Repository\ZvireRepository;
use DateTime;

class HmotnostPresenter extends Presenter
{
    private $auth;
    private $zvire;
    public function __construct(Authorization $auth, ZvireRepository $zvire)
    {
        $this->auth = $auth;
        $this->zvire = $zvire;
    }
    public function actionHmotnost(int $id_zvire, int $id_hmotnost): void
    {  
       
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header('Access-Control-Allow-Credentials: true');
        

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            $this->sendJson("xxx");
        }

        $id_uzivatel = $this->auth->authorize();

        if($id_uzivatel){

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $date = new DateTime($_POST['datum']);
            $this->zvire->pridatHmotnost($id_uzivatel,$id_zvire,$_POST['hmotnost'],$date);
            $res= $this->zvire->vratHmotnost($id_uzivatel,$id_zvire);
            $this->sendJson($res);
            }

            if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
            $res= $this->zvire->vratHmotnost($id_uzivatel,$id_zvire);
            $this->sendJson($res);

            }

            if ($_SERVER['REQUEST_METHOD'] == 'DELETE') { 
                
                $this->zvire->smazatHmotnost($id_uzivatel,$id_zvire, $id_hmotnost); 
                $res= $this->zvire->vratHmotnost($id_uzivatel,$id_zvire);
                $this->sendJson($res);
               
            }

        }

        }
} 