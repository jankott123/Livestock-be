<?php

namespace App\Model\Repository;

use Nettrine\ORM\EntityManagerDecorator;
use App\Model\Entity\Staj;
use App\Model\Service;
use DateTime;

class StajRepository
{
    private $decorator;

    public function __construct(EntityManagerDecorator $decorator)
    {
        $this->decorator = $decorator;
    }

    public function pridatStaj($nazev, $id_uzivatele, $druh_zvirete): void
    {
        $id_uzivatele =  $this->decorator->getRepository("App\Model\Entity\Uzivatel")->findOneBy(["id" => $id_uzivatele]);
        $my_date = date("j. n. Y");

        $staj = new Staj();
        $staj->setNazev($nazev);
        $staj->setDruh_zvirete($druh_zvirete);
        $staj->setId_uzivatele($id_uzivatele);
        $staj->setDatum($my_date);

        $this->decorator->persist($staj);

        $this->decorator->flush();
    }

    public function vratStajeUzivatele($id_uzivatele)
    {

        $id_uzivatele =  $this->decorator->getRepository("App\Model\Entity\Uzivatel")->findOneBy(["id" => $id_uzivatele]);

        $qb = $this->decorator->createQueryBuilder();
        $qb->select('u')
            ->from('App\Model\Entity\Staj', 'u')
            ->where('u.id_uzivatele = :id')
            ->setParameter('id', $id_uzivatele);

        $query = $qb->getQuery();

        $res = $query->getArrayResult();

        return $res;
    }

    public function vratStajpodleId($id_staje)
    {

        return $this->decorator->getRepository("App\Model\Entity\Staj")->findOneBy(["id" => $id_staje]);
    }

    public function smazatStaj($id_uzivatele, $id_staje)
    {
        $id_uzivatele =  $this->decorator->getRepository("App\Model\Entity\Uzivatel")->findOneBy(["id" => $id_uzivatele]);

        $query = $this->decorator->createQuery('DELETE App\Model\Entity\Staj u WHERE u.id = :id AND u.id_uzivatele= :id_uzivatele');
        $query->setParameters(array(
            'id' => $id_staje,
            'id_uzivatele' => $id_uzivatele
        ));

        return $query->getResult();
    }

    public function vratStajeUzivatele2($id_uzivatele2)
    {

        $qb = $this->decorator->createQueryBuilder();
        $qb->select('u, COUNT(g)')
            ->from('App\Model\Entity\Staj', 'u')
            ->where('u.id_uzivatele = :id')
            ->setParameter('id', $id_uzivatele2)
            ->LeftJoin('App\Model\Entity\Zvire', 'g', 'WITH', 'u.id = g.id_staj')
            ->groupBy('g.id_staj, u');

        $query = $qb->getQuery();

        $res = $query->getArrayResult();

        $arr = array();

        for ($i = 0; $i < count($res); $i++) {
            $arr[$i] = new Service();
            $arr[$i]->id = $res[$i][0]["id"];
            $arr[$i]->nazev = $res[$i][0]["nazev"];
            $arr[$i]->datum = $res[$i][0]["datum"];
            $arr[$i]->druh = $res[$i][0]["druh_zvirete"];
            $arr[$i]->pocet_zvirat = $res[$i][1];
        }


        return $arr;
    }
}
