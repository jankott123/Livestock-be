<?php

namespace App\Presenters;

use App\Model\Authorization;
use App\Model\Repository\UzivatelRepository;
use Nette\Application\UI\Presenter;
use App\Model\Repository\ZvireRepository;

class UzivatelPresenter extends Presenter
{
    private $auth;
    private $uzivatel;

    public function __construct(Authorization $auth, UzivatelRepository $uzivatel)
    {
        $this->auth = $auth;
        $this->uzivatel = $uzivatel;
    }

    public function actioneditUzivatel()
    {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Credentials: true");

        $id_uzivatel = $this->auth->authorize();

        if ($id_uzivatel) {

            $this->uzivatel->editUzivatel(
                $id_uzivatel,
                $_POST["Jméno"],
                $_POST["Příjmení"],
                $_POST["Telefon"],
                $_POST["Email"],
                $_POST["Ulice"],
                $_POST["Číslo_popisné"],
                $_POST["Město"],
                $_POST["Psč"]
            );

           $this->actionVratUzivatele($id_uzivatel);
        }
    }

    public function actionVratUzivatele()
    {
        
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Credentials: true");

        $id_uzivatel = $this->auth->authorize();

        if ($id_uzivatel) {
            $uzivatel=$uzivatel=$this->uzivatel->vratUzivatele($id_uzivatel);
            $this->sendJson($uzivatel);
        }

    }

}
