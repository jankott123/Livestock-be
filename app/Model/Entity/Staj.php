<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="staj")
 */
class Staj
{
    /**
    * @var int
    *
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="IDENTITY")
    */
    private  $id;

    /**
     * @var string nazev
     * 
     * @ORM\Column(name="nazev", type="string", length=50)
     */
    private $nazev;

    /**
     * @var string nazev
     * 
     * @ORM\Column(name="druh_zvirete", type="string", length=50)
     */
    private $druh_zvirete;

     /**
     * @var int
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Uzivatel")
     * @ORM\JoinColumn(name="id_uzivatele", referencedColumnName="id", onDelete="RESTRICT")
     */
    private $id_uzivatele;

    /**
     * @var string datum
     * @ORM\Column(name="date", type="string", length=50)
     */
    private $datum;









    /**
     * Get nazev
     *
     * @return  string
     */ 
    public function getNazev()
    {
        return $this->nazev;
    }

    /**
     * Set nazev
     *
     * @param  string  $nazev  nazev
     *
     * @return  self
     */ 
    public function setNazev(string $nazev)
    {
        $this->nazev = $nazev;

        return $this;
    }

    /**
     * Get many features have one product. This is the owning side.
     *
     * @return  int
     */ 
    public function getId_uzivatele()
    {
        return $this->id_uzivatele;
    }

    /**
     * Set many features have one product. This is the owning side.
     *
     * @param  int  $id_uzivatele  Many features have one product. This is the owning side.
     *
     * @return  self
     */ 
    public function setId_uzivatele($id_uzivatele)
    {
        $this->id_uzivatele = $id_uzivatele;

        return $this;
    }

    /**
     * Get the value of datum
     *
     * 
     */ 
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * Set the value of datum
     *
     * 
     *
     * @return  self
     */ 
    public function setDatum($datum)
    {
        $this->datum = $datum;

        return $this;
    }

    /**
     * Get nazev
     *
     * @return  string
     */ 
    public function getDruh_zvirete()
    {
        return $this->druh_zvirete;
    }

    /**
     * Set nazev
     *
     * @param  string  $druh_zvirete  nazev
     *
     * @return  self
     */ 
    public function setDruh_zvirete(string $druh_zvirete)
    {
        $this->druh_zvirete = $druh_zvirete;

        return $this;
    }
}