<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Presenter;

use App\Model\Authorization;
use App\Model\Repository\StajRepository;
use App\Model\Repository\ZvireRepository;

class GrafPresenter extends Presenter
{
    private $auth;
    private $zvire;
    public function __construct(Authorization $auth, ZvireRepository $zvire)
    {
        $this->auth = $auth;
        $this->zvire = $zvire;
    }

    public function actionPocetZviratAStaji()
    {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Credentials: true");

        $id_uzivatel = $this->auth->authorize();

        if ($id_uzivatel) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $pocet = $this->zvire->pocetZvirat($id_uzivatel);
                $this->sendJson($pocet);
            }
        }
    }

    public function actionZastoupeniZvirat()
    {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Credentials: true");

        $id_uzivatel = $this->auth->authorize();

        if ($id_uzivatel) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $zastoupeni = $this->zvire->zastoupeniZvirat($id_uzivatel);
                $this->sendJson($zastoupeni);
            }
        }
    }

    public function actionDojeneZvirata()
    {

        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Credentials: true");

        $id_uzivatel = $this->auth->authorize();

        if ($id_uzivatel) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $dojene = $this->zvire->dojeneZvirata($id_uzivatel);
                $this->sendJson($dojene);
            }
        }
    }

    public function actionPocetZviratStaje()
    {

        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Credentials: true");

        $id_uzivatel = $this->auth->authorize();

        if ($id_uzivatel) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $pocet = $this->zvire->pocetZviratStaje($id_uzivatel);
                $this->sendJson($pocet);
            }
        }
    }

    public function actionVratVsechnaZvirata($id_uzivatel)
    {

        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Credentials: true");

        $id_uzivatel = $this->auth->authorize();

        if ($id_uzivatel) {
            $zvirata = $this->zvire->vratVsechnaZvirataUzitele($id_uzivatel);
            $this->sendJson($zvirata);
        }
    }
}
