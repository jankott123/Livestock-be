<?php

namespace App\Presenters;

use App\Model\Authorization;
use Nette\Application\UI\Presenter;
use App\Model\Repository\ZvireRepository;

class ZvirePresenter extends Presenter
{
    private $auth;
    private $zvire;

    public function __construct(Authorization $auth, ZvireRepository $zvire)
    {
        $this->auth = $auth;
        $this->zvire = $zvire;
    }

    // cislo staje pro GET pozadavek je id_zvirete 
    public function actionZvire($cislo_staje)
    {

        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Credentials: true");




        $id_uzivatel = $this->auth->authorize();

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            $this->sendJson("xxx");
        }

        if ($id_uzivatel) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $this->zvire->pridatZvire(
                    $_POST['identif_cislo'],
                    $id_uzivatel,
                    $_POST["pohlavi"],
                    $_POST["plemeno"],
                    $_POST["dojene"],
                    $_POST["datum"],
                    $_POST["matka"],
                    $_POST["otec"],
                    $_POST["id_staje"]
                );

                $zvirata = $this->zvire->zvirePodleStaje($id_uzivatel, $cislo_staje);
                $this->sendJson($zvirata);
            }

            if ($_SERVER['REQUEST_METHOD'] == 'GET') {

                $id_zvirete = $cislo_staje;

                $detail_zvire = $this->zvire->detailZvire($id_uzivatel, $id_zvirete);
                $this->sendJson($detail_zvire);
            }

            if ($_SERVER['REQUEST_METHOD'] == 'DELETE') { 
                
                $id_zvirete = $cislo_staje; 
                $id_staje = $this->zvire->smazatZvire($id_uzivatel, $id_zvirete);
                $zvirata = $this->zvire->zvirePodleStaje($id_uzivatel, $id_staje);

                $this->sendJson($zvirata);
                
            }

            if ($_SERVER['REQUEST_METHOD'] == 'PUT') { 
                $id_zvirete = $cislo_staje; 
                $myEntireBody = file_get_contents('php://input'); 
                $data = json_decode($myEntireBody);

                $identifikacni_cislo = $data->identifikacni_cislo;
                $pohlavi = $data->pohlavi;
                $plemeno = $data->plemeno;
                $dojene = $data->dojene;
                $datum = $data->datum;
                $matka = $data->matka;
                $otec = $data->otec;


                $this->zvire->editaceZvire($id_uzivatel, $id_zvirete, $identifikacni_cislo, $pohlavi, $plemeno, $dojene, $datum, $matka, $otec);
                $detail_zvire = $this->zvire->detailZvire($id_uzivatel, $id_zvirete);
                $this->sendJson($detail_zvire);
            }

        }
    }
}
