<?php

namespace App\Model\Repository;

use Nettrine\ORM\EntityManagerDecorator;
use App\Model\Entity\Uzivatel;

class UzivatelRepository
{
    private $decorator;

    public function __construct(EntityManagerDecorator $decorator)
    {
        $this->decorator = $decorator;
    }

    public function create_user($username, $password, $email, $uniqid)
    {
        $user = new Uzivatel();
        $user->setUzivatel_jmeno($username);
        $user->setHeslo($password);
        $user->setEmail($email);
        $user->setAktivacni_klic($uniqid);

        $this->decorator->persist($user);

        $this->decorator->flush();
    }

    public function get_user($username)
    {
        return $this->decorator->getRepository("App\Model\Entity\Uzivatel")->findOneBy(["uzivatel_jmeno" => $username]);
    }

    public function get_email($email)
    {
        return $this->decorator->getRepository("App\Model\Entity\Uzivatel")->findOneBy(["email" => $email]);
    }

    public function get_user_by_id($id)
    {
        return $this->decorator->getRepository("App\Model\Entity\Uzivatel")->findOneBy(["id" => $id]);
    }

    public function editUzivatel($id_uzivatel, $jmeno, $prijmeni, $telefon, $email, $ulice, $cislo_popisne, $mesto, $psc){
       
       $uzivatel= $this->decorator->getRepository("App\Model\Entity\Uzivatel")->findOneBy(["id" => $id_uzivatel]);
        
       if(empty($telefon)){
           $telefon=null;
       }
       if(empty($cislo_popisne)){
        $cislo_popisne=null;
        }
        if(empty($psc)){
            $psc=null;
        }

        $uzivatel->setEmail($email);
        $uzivatel->setTelefon($telefon);
        $uzivatel->setMesto($mesto);
        $uzivatel->setUlice($ulice);
        $uzivatel->setPsc($psc);
        $uzivatel->setCislo_popisne($cislo_popisne);
        $uzivatel->setJmeno($jmeno);
        $uzivatel->setPrijmeni($prijmeni);

        $this->decorator->merge($uzivatel);
        $this->decorator->flush();

    }

    public function vratUzivatele($id_uzivatel){

        $id_uzivatele =  $this->decorator->getRepository("App\Model\Entity\Uzivatel")->findOneBy(["id" => $id_uzivatel]);

        $qb = $this->decorator->createQueryBuilder();
        $qb->select('u.jmeno, u.prijmeni, u.telefon, u.email, u.ulice, u.cislo_popisne, u.mesto, u.psc')
            ->from('App\Model\Entity\Uzivatel', 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id_uzivatele);

        $query = $qb->getQuery();

        $res = $query->getArrayResult();

        return $res;
    }

    
}
