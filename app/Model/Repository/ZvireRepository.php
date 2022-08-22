<?php

namespace App\Model\Repository;

use App\Model\Entity\Hmotnost;
use Nettrine\ORM\EntityManagerDecorator;
use App\Model\Entity\Zvire;
use DateTime;
use App\Model\Entity\Uzivatel;
use App\Model\Entity\Staj;
use Doctrine\DBAL\Types\ObjectType;
use App\Model\Service;

class ZvireRepository
{
    private $decorator;

    public function __construct(EntityManagerDecorator $decorator)
    {
        $this->decorator = $decorator;
    }

    public function pridatZvire($identif_cislo, $id_uzivatele, $pohlavi, $plemeno, $dojene, $datum, $matka, $otec, $id_staje)
    {
        $id_uzivatele =  $this->decorator->getRepository("App\Model\Entity\Uzivatel")->findOneBy(["id" => $id_uzivatele]);
        $id_staje =  $this->decorator->getRepository("App\Model\Entity\Staj")->findOneBy(["id" => $id_staje]);

        $qb = $this->decorator->createQueryBuilder();
        $qb->select('u.druh_zvirete')
            ->from('App\Model\Entity\Staj', 'u')
            ->where('u.id = :id_staje')
            ->setParameter('id_staje', $id_staje);

        $query = $qb->getQuery();
        $res = $query->getResult();

        $res[0]["druh_zvirete"];

        if ($this->overeniVlastnika($id_uzivatele, $id_staje)) {
            $zvire = new Zvire();
            $zvire->setNazev_druhu($res[0]["druh_zvirete"]);
            $zvire->setId_uzivatele($id_uzivatele);
            $zvire->setPohlavi($pohlavi);
            $zvire->setId_staj($id_staje);
            $zvire->setIdentifikacni_cislo($identif_cislo);
            $zvire->setPlemeno($plemeno);
            $zvire->setMatka($matka);
            $zvire->setOtec($otec);
            $zvire->setDojene($dojene);
            $zvire->setDatum_narozeni($datum);

            $this->decorator->persist($zvire);

            $this->decorator->flush();
        } else {
            return "error";
        }
    }

    // vraci vsechna zvirata ze staje podle jejiho ID
    public function zvirePodleStaje($id_uzivatele, $id_staje)
    {

        if ($this->overeniVlastnika($id_uzivatele, $id_staje)) {

            $qb = $this->decorator->createQueryBuilder();
            $qb->select('u')
                ->from('App\Model\Entity\Zvire', 'u')
                ->where('u.id_staj = :id')
                ->setParameter('id', $id_staje);

            $query = $qb->getQuery();

            $res = $query->getArrayResult();
            return $res;
        }
    }

    public function overeniVlastnika($id_uzivatele, $id_staje)
    {

        $id_uzivatele =  $this->decorator->getRepository("App\Model\Entity\Uzivatel")->findOneBy(["id" => $id_uzivatele]);
        $id_staje =  $this->decorator->getRepository("App\Model\Entity\Staj")->findOneBy(["id" => $id_staje]);

        $qb = $this->decorator->createQueryBuilder();
        $qb->select('u')
            ->from('App\Model\Entity\Staj', 'u')
            ->innerJoin('App\Model\Entity\Uzivatel', 'g', 'WITH', 'u.id_uzivatele = g.id')
            ->where('g.id = :id_uzivatele')
            ->andWhere('u.id = :id_staje')
            ->setParameters(array(
                'id_uzivatele' => $id_uzivatele,
                "id_staje" => $id_staje
            ));

        $query = $qb->getQuery();

        $res = $query->getResult();

        return $res;
    }

    public function detailZvire($id_uzivatele, $id_zvire)
    {


        $qb = $this->decorator->createQueryBuilder();
        $qb->select('u')
            ->from('App\Model\Entity\Zvire', 'u')
            ->where('u.id_uzivatele = :id')
            ->andWhere("u.id = :id_zvire")
            ->setParameters(array(
                'id' => $id_uzivatele,
                'id_zvire' => $id_zvire,
            ));

        $query = $qb->getQuery();

        $res = $query->getResult();

        if ($res) {

            $qb = $this->decorator->createQueryBuilder();
            $qb->select('u')
                ->from('App\Model\Entity\Zvire', 'u')
                ->where('u.id = :id')
                ->setParameter(
                    'id',
                    $id_zvire
                );

            $query = $qb->getQuery();

            $res = $query->getArrayResult();

            return $res;
        }
    }

    public function pridatHmotnost($id_uzivatele, $id_zvire, $hmotnost, $datum)
    {

        $id_zvire =  $this->decorator->getRepository("App\Model\Entity\Zvire")->findOneBy(["id" => $id_zvire]);
        $qb = $this->decorator->createQueryBuilder();
        $qb->select('u')
            ->from('App\Model\Entity\Zvire', 'u')
            ->where('u.id_uzivatele = :id')
            ->andWhere("u.id = :id_zvire")
            ->setParameters(array(
                'id' => $id_uzivatele,
                'id_zvire' => $id_zvire,
            ));

        $query = $qb->getQuery();

        $res = $query->getResult();

        if ($res) {
            $zvire = new Hmotnost();
            $zvire->setHmotnost($hmotnost);
            $zvire->setId_zvirete($id_zvire);
            $zvire->setDatum($datum);


            $this->decorator->persist($zvire);

            $this->decorator->flush();
        }
    }

    public function vratHmotnost($id_uzivatele, $id_zvire)
    {
        $id_zvire =  $this->decorator->getRepository("App\Model\Entity\Zvire")->findOneBy(["id" => $id_zvire]);
        $qb = $this->decorator->createQueryBuilder();
        $qb->select('u')
            ->from('App\Model\Entity\Zvire', 'u')
            ->where('u.id_uzivatele = :id')
            ->andWhere("u.id = :id_zvire")
            ->setParameters(array(
                'id' => $id_uzivatele,
                'id_zvire' => $id_zvire,
            ));

        $query = $qb->getQuery();

        $res = $query->getResult();

        if ($res) {

            $qb = $this->decorator->createQueryBuilder();
            $qb->select('u.id AS id, u.datum, u.hmotnost')
                ->add('orderBy', 'u.datum ASC')
                ->from('App\Model\Entity\Hmotnost', 'u')
                ->where('u.id_zvirete = :id')
                ->setParameter(
                    'id',
                    $id_zvire
                );

            $query = $qb->getQuery();

            $res = $query->getArrayResult();

            return $res;
        }
    }

    public function smazatHmotnost($id_uzivatel, $id_zvire, $id_hmotnost){

        $id_zvire =  $this->decorator->getRepository("App\Model\Entity\Zvire")->findOneBy(["id" => $id_zvire]);
        $qb = $this->decorator->createQueryBuilder();
        $qb->select('u')
            ->from('App\Model\Entity\Zvire', 'u')
            ->where('u.id_uzivatele = :id')
            ->andWhere("u.id = :id_zvire")
            ->setParameters(array(
                'id' => $id_uzivatel,
                'id_zvire' => $id_zvire,
            ));

        $query = $qb->getQuery();

        $res = $query->getResult();

        if ($res) {

            $query = $this->decorator->createQuery('DELETE App\Model\Entity\Hmotnost u WHERE u.id = :id AND u.id_zvirete= :id_zvirete');
            $query->setParameters(array(
                'id' => $id_hmotnost,
                'id_zvirete' => $id_zvire
            ));
            $query->getResult();

        }

    }

    public function smazatZvire($id_uzivatele, $id_zvire)
    {

        $id_uzivatele =  $this->decorator->getRepository("App\Model\Entity\Uzivatel")->findOneBy(["id" => $id_uzivatele]);

        $id_staje = $this->vratCisloStaje($id_uzivatele, $id_zvire);

        $query = $this->decorator->createQuery('DELETE App\Model\Entity\Zvire u WHERE u.id = :id AND u.id_uzivatele= :id_uzivatele');
        $query->setParameters(array(
            'id' => $id_zvire,
            'id_uzivatele' => $id_uzivatele
        ));
        $query->getResult();

        return $id_staje;
    }


    public function vratCisloStaje($id_uzivatele, $id_zvire)
    {

        $qb = $this->decorator->createQueryBuilder();
        $qb->select('IDENTITY(u.id_staj)')
            ->from('App\Model\Entity\Zvire', 'u')
            ->where('u.id_uzivatele = :id')
            ->andWhere("u.id = :id_zvire")
            ->setParameters(array(
                'id' => $id_uzivatele,
                'id_zvire' => $id_zvire,
            ));

        $query = $qb->getQuery();

        $res = $query->getResult();
        return $res[0][1];
    }

    public function editaceZvire($id_uzivatel, $id_zvirete, $identifikacni_cislo, $pohlavi, $plemeno, $dojene, $datum, $matka, $otec)
    {


        $zvire = $this->decorator->getRepository("App\Model\Entity\Zvire")->findOneBy(["id" => $id_zvirete, "id_uzivatele" => $id_uzivatel]);

        $zvire->setIdentifikacni_cislo($identifikacni_cislo);
        $zvire->setDatum_narozeni($datum);
        $zvire->setPohlavi($pohlavi);
        $zvire->setPlemeno($plemeno);
        $zvire->setMatka($matka);
        $zvire->setOtec($otec);
        $zvire->setDojene($dojene);
        
        $this->decorator->flush();
      
    }

    public function pocetZvirat($id_uzivatel){

        $qb = $this->decorator->createQueryBuilder();
        $qb->select('COUNT (u)')
            ->from('App\Model\Entity\Zvire', 'u')
            ->where('u.id_uzivatele = :id_uzivatel')
            ->setParameter('id_uzivatel', $id_uzivatel);

        $query = $qb->getQuery();
        $zvirata_pocet = $query->getResult();
        $staje_pocet = $this->pocetStaji($id_uzivatel);
    
        $pocet = array($staje_pocet[0][1],$zvirata_pocet[0][1]);

        return $pocet;

    }

    public function pocetStaji($id_uzivatel){

        $qb = $this->decorator->createQueryBuilder();
        $qb->select('COUNT (u)')
            ->from('App\Model\Entity\Staj', 'u')
            ->where('u.id_uzivatele = :id_uzivatel')
            ->setParameter('id_uzivatel', $id_uzivatel);

        $query = $qb->getQuery();
        return $query->getResult();

    }



    public function zastoupeniZvirat($id_uzivatel){ 
        $qb = $this->decorator->createQueryBuilder();
        $qb->select('COUNT (u.nazev_druhu), u.nazev_druhu')
            ->from('App\Model\Entity\Zvire', 'u')
            ->where('u.id_uzivatele = :id_uzivatel')
            ->groupBy('u.nazev_druhu')
            ->setParameter('id_uzivatel', $id_uzivatel);

        $query = $qb->getQuery();
        $res = $query->getResult();

        return $res;
    }

    public function dojeneZvirata($id_uzivatel){

        $qb = $this->decorator->createQueryBuilder();
        $qb->select('COUNT (u.nazev_druhu), u.nazev_druhu')
            ->from('App\Model\Entity\Zvire', 'u')
            ->where('u.id_uzivatele = :id_uzivatel')
            ->andWhere('u.dojene = :dojene')
            ->groupBy('u.nazev_druhu')
            ->setParameters(array('id_uzivatel' => $id_uzivatel, 'dojene' => "ano" ));

        $query = $qb->getQuery();
        $dojene = $query->getResult();

        $arr = array();
        for ($i = 0; $i < count($dojene); $i++) {
            $arr[$i] = new Service();
            $arr[$i]->pocet = $dojene[$i]["1"];
            $arr[$i]->nazev_druhu = $dojene[$i]["nazev_druhu"];
        }
        $dojene=$arr;

        $nedojene1= $this->nedojeneZvirata($id_uzivatel);
        $nedojene = new Service();
        $nedojene->pocet = $nedojene1[0]["1"];
        $nedojene->nazev_druhu = "Nedojené";
        
        array_push($dojene,$nedojene);
        return $dojene;
    }

    public function nedojeneZvirata($id_uzivatel){ 

        $qb = $this->decorator->createQueryBuilder();
        $qb->select('COUNT (u)')
            ->from('App\Model\Entity\Zvire', 'u')
            ->where('u.id_uzivatele = :id_uzivatel')
            ->andWhere('u.dojene = :dojene')
            ->setParameters(array('id_uzivatel' => $id_uzivatel, 'dojene' => "ne" ));

        $query = $qb->getQuery();
        $res = $query->getResult();
        
        return $res;
    }

    public function pocetZviratStaje($id_uzivatel){
        $qb = $this->decorator->createQueryBuilder();
        $qb->select('u, COUNT(g)')
            ->from('App\Model\Entity\Staj', 'u')
            ->where('u.id_uzivatele = :id')
            ->setParameter('id', $id_uzivatel)
            ->LeftJoin('App\Model\Entity\Zvire', 'g', 'WITH', 'u.id = g.id_staj')
            ->groupBy('g.id_staj, u');

        $query = $qb->getQuery();

        $res = $query->getArrayResult();

        $arr = array();

        for ($i = 0; $i < count($res); $i++) {
            $arr[$i] = new Service();
            $arr[$i]->nazev = $res[$i][0]["nazev"];
            $arr[$i]->pocet_zvirat = $res[$i][1];
        }


        return $arr;

    }

    public function vratVsechnaZvirataUzitele($id_uzivatel){
        $qb = $this->decorator->createQueryBuilder();
        $qb->select('u')
            ->from('App\Model\Entity\Zvire', 'u')
            ->where('u.id_uzivatele = :id_uzivatel')
            ->setParameter('id_uzivatel', $id_uzivatel);

        $query = $qb->getQuery();
        $res = $query->getArrayResult();

        return $res;
    }
}
