<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Presenter;

use App\Model\Authorization;
use App\Model\Repository\StajRepository;
use App\Model\Repository\ZvireRepository;

class StajPresenter extends Presenter
{
    private $auth;
    private $stajrepo;
    private $zvire;
    public function __construct(Authorization $auth, StajRepository $stajRepository, ZvireRepository $zvire)
    {
        $this->auth = $auth;
        $this->stajrepo = $stajRepository;
        $this->zvire = $zvire;
    }
    public function actionStaj(int $cislo_staje): void
    {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header('Access-Control-Allow-Credentials: true');

        $id_uzivatel = $this->auth->authorize();

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            $this->sendJson("xxx");
        }


        if ($id_uzivatel) {
            // pridani nove staje 

            //prida staj
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->stajrepo->pridatStaj($_POST['staj_name'], $id_uzivatel, $_POST["vyber_zvirete"]);
                $res = $this->stajrepo->vratStajeUzivatele2($id_uzivatel);
                $this->sendJson($res);
            }

            // vrati staje uzivatele
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && !$cislo_staje) {
                $res = $this->stajrepo->vratStajeUzivatele2($id_uzivatel);
                $this->sendJson($res);
            }
            // vrati zvirata v dane staji 
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && $cislo_staje) {
                $zvirata = $this->zvire->zvirePodleStaje($id_uzivatel, $cislo_staje);
                $this->sendJson($zvirata);
            }

            //smaze staj
            if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
                $res = $this->stajrepo->smazatStaj($id_uzivatel, $cislo_staje);
                $res = $this->stajrepo->vratStajeUzivatele2($id_uzivatel);
                $this->sendJson($res);
            }
        }




        $this->sendJson("not authorized");
    }
}
