<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="uzivatel")
 */
class Uzivatel
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
     * @var string uzitavel_jmeno
     * 
     * @ORM\Column(name="uzivatel_jmeno", type="string", length=50)
     */
    private $uzivatel_jmeno;


      /**
     * @var string 
     * 
     * @ORM\Column(name="heslo", type="string", length=500)
     */
    private $heslo;

    /**
     * @var string 
     * 
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;


    /**
     * @var int
     * 
     * @ORM\Column(name="telefon", type="integer", nullable=true)
     */
    private $telefon;


     /**
     * @var string 
     * 
     * @ORM\Column(name="mesto", type="string", length=100, nullable=true)
     */
    private $mesto;


     /**
     * @var string 
     * 
     * @ORM\Column(name="ulice", type="string", length=100, nullable=true)
     */
    private $ulice;



     /**
     * @var int
     * 
     * @ORM\Column(name="psc", type="integer",  nullable=true)
     */
    private $psc;


     /**
     * @var int
     * 
     * @ORM\Column(name="cislo_popisne", type="integer",  nullable=true)
     */
    private $cislo_popisne;

      /**
     * @var string 
     * 
     * @ORM\Column(name="jmeno", type="string", length=100, nullable=true)
     */
    private $jmeno;

      /**
     * @var string 
     * 
     * @ORM\Column(name="prijmeni", type="string", length=100, nullable=true)
     */
    private $prijmeni;



    /**
     * @var string 
     * 
     * @ORM\Column(name="aktivacni_klic", type="string", length=50, nullable=TRUE)
     */
    private $aktivacni_klic;






    /**
     * Get uzitavel_jmeno
     *
     * @return  string
     */ 
    public function getUzivatel_jmeno()
    {
        return $this->uzivatel_jmeno;
    }

    /**
     * Set uzitavel_jmeno
     *
     * @param  string  $uzivatel_jmeno  uzitavel_jmeno
     *
     * @return  self
     */ 
    public function setUzivatel_jmeno(string $uzivatel_jmeno)
    {
        $this->uzivatel_jmeno = $uzivatel_jmeno;

        return $this;
    }

    /**
     * Get the value of heslo
     *
     * @return  string
     */ 
    public function getHeslo()
    {
        return $this->heslo;
    }

    /**
     * Set the value of heslo
     *
     * @param  string  $heslo
     *
     * @return  self
     */ 
    public function setHeslo(string $heslo)
    {
        $this->heslo = $heslo;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of aktivacni_klic
     *
     * @return  string
     */ 
    public function getAktivacni_klic()
    {
        return $this->aktivacni_klic;
    }

    /**
     * Set the value of aktivacni_klic
     *
     * @param  string  $aktivacni_klic
     *
     * @return  self
     */ 
    public function setAktivacni_klic(string $aktivacni_klic)
    {
        $this->aktivacni_klic = $aktivacni_klic;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of telefon
     *
     * @return  int
     */ 
    public function getTelefon()
    {
        return $this->telefon;
    }

    /**
     * Set the value of telefon
     *
     * 
     *
     * @return  self
     */ 
    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;

        return $this;
    }

    /**
     * Get the value of mesto
     *
     * @return  string
     */ 
    public function getMesto()
    {
        return $this->mesto;
    }

    /**
     * Set the value of mesto
     *
     * @param  string  $mesto
     *
     * @return  self
     */ 
    public function setMesto(string $mesto)
    {
        $this->mesto = $mesto;

        return $this;
    }

    /**
     * Get the value of ulice
     *
     * @return  string
     */ 
    public function getUlice()
    {
        return $this->ulice;
    }

    /**
     * Set the value of ulice
     *
     * @param  string  $ulice
     *
     * @return  self
     */ 
    public function setUlice(string $ulice)
    {
        $this->ulice = $ulice;

        return $this;
    }

    /**
     * Get the value of psc
     *
     * @return  int
     */ 
    public function getPsc()
    {
        return $this->psc;
    }

    /**
     * Set the value of psc
     *
     *
     *
     * @return  self
     */ 
    public function setPsc($psc)
    {
        $this->psc = $psc;

        return $this;
    }

    /**
     * Get the value of cislo_popisne
     *
     * @return  int
     */ 
    public function getCislo_popisne()
    {
        return $this->cislo_popisne;
    }

    /**
     * Set the value of cislo_popisne
     *
     * 
     *
     * @return  self
     */ 
    public function setCislo_popisne($cislo_popisne)
    {
        $this->cislo_popisne = $cislo_popisne;

        return $this;
    }

    /**
     * Get the value of jmeno
     *
     * @return  string
     */ 
    public function getJmeno()
    {
        return $this->jmeno;
    }

    /**
     * Set the value of jmeno
     *
     * @param  string  $jmeno
     *
     * @return  self
     */ 
    public function setJmeno(string $jmeno)
    {
        $this->jmeno = $jmeno;

        return $this;
    }

    /**
     * Get the value of prijmeni
     *
     * @return  string
     */ 
    public function getPrijmeni()
    {
        return $this->prijmeni;
    }

    /**
     * Set the value of prijmeni
     *
     * @param  string  $prijmeni
     *
     * @return  self
     */ 
    public function setPrijmeni(string $prijmeni)
    {
        $this->prijmeni = $prijmeni;

        return $this;
    }
}