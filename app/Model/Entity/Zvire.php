<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="zvire")
 */
class Zvire
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
   * @var string
   *
   * @ORM\Column(name="usni_cislo", type="string", length=50)
   */
  private $identifikacni_cislo;

  /**
   * @var string datum_narozeni
   * @ORM\Column(name="datum_narozeni", type="string", length=50)
   */
  private $datum_narozeni;


  /**
   * @var string nazev_druhu
   * 
   * @ORM\Column(name="nazev_druhu", type="string", length=50)
   */
  private $nazev_druhu;

  /**
   * @var string pohlavi
   * 
   * @ORM\Column(name="pohlavi", type="string", length=12)
   */
  private $pohlavi;

  /**
   * @var string plemeno
   * 
   * @ORM\Column(name="plemeno", type="string", length=12)
   */
  private $plemeno;

  /**
   * @var string matka
   * 
   * @ORM\Column(name="matka", type="string", length=30)
   */
  private $matka;

  /**
   * @var string otec
   * 
   * @ORM\Column(name="otec", type="string", length=30)
   */
  private $otec;

  /**
   * @var string dojene
   * 
   * @ORM\Column(name="dojene", type="string", length=30)
   */
  private $dojene; 


  /**
   * @var int
   * Many features have one product. This is the owning side.
   * @ORM\ManyToOne(targetEntity="Uzivatel")
   * @ORM\JoinColumn(name="id_uzivatele", referencedColumnName="id", onDelete="RESTRICT")
   */
  private $id_uzivatele;

  /**
   * @var int
   * Many features have one product. This is the owning side.
   * @ORM\ManyToOne(targetEntity="Staj")
   * @ORM\JoinColumn(name="id_staj", referencedColumnName="id", onDelete="CASCADE")
   */
  private $id_staj;

  public function setNazev_druhu($nazev_druhu)
  {
    $this->nazev_druhu = $nazev_druhu;
    return $this;
  }

  public function getNazev_druhu()
  {
    return $this->nazev_druhu;
  }

  public function setPohlavi($pohlavi)
  {
    $this->pohlavi = $pohlavi;
  }

  public function getPohlavi()
  {
    return $this->pohlavi;
  }

  public function setId_uzivatele($id_uzivatele)
  {
    $this->id_uzivatele = $id_uzivatele;
  }

  public function getId_uzivatele()
  {
    return $this->id_uzivatele;
  }

 



  /**
   * Get the value of usni_cislo
   *
   * 
   */
  public function getIdentifikacni_cislo()
  {
    return $this->identifikacni_cislo;
  }

  /**
   * Set the value of usni_cislo
   *
   * 
   *
   * @return  self
   */
  public function setIdentifikacni_cislo($identifikacni_cislo)
  {
    $this->identifikacni_cislo = $identifikacni_cislo;

    return $this;
  }

  /**
   * Get the value of datum_narozeni
   */
  public function getDatum_narozeni()
  {
    return $this->datum_narozeni;
  }

  /**
   * Set the value of datum_narozeni
   *
   * @return  self
   */
  public function setDatum_narozeni($datum_narozeni)
  {
    $this->datum_narozeni = $datum_narozeni;

    return $this;
  }

  /**
   * Get plemeno
   *
   * @return  string
   */
  public function getPlemeno()
  {
    return $this->plemeno;
  }

  /**
   * Set plemeno
   *
   * @param  string  $plemeno  plemeno
   *
   * @return  self
   */
  public function setPlemeno(string $plemeno)
  {
    $this->plemeno = $plemeno;

    return $this;
  }

  /**
   * Get matka
   *
   * @return  string
   */
  public function getMatka()
  {
    return $this->matka;
  }

  /**
   * Set matka
   *
   * @param  string  $matka  matka
   *
   * @return  self
   */
  public function setMatka(string $matka)
  {
    $this->matka = $matka;

    return $this;
  }

  /**
   * Get matka
   *
   * @return  string
   */
  public function getOtec()
  {
    return $this->otec;
  }

  /**
   * Set matka
   *
   * @param  string  $otec  matka
   *
   * @return  self
   */
  public function setOtec(string $otec)
  {
    $this->otec = $otec;

    return $this;
  }

  /**
   * Get dojene
   *
   * @return  string
   */ 
  public function getDojene()
  {
    return $this->dojene;
  }

  /**
   * Set dojene
   *
   * @param  string  $dojene  dojene
   *
   * @return  self
   */ 
  public function setDojene(string $dojene)
  {
    $this->dojene = $dojene;

    return $this;
  }

  /**
   * Get many features have one product. This is the owning side.
   *
   * 
   */ 
  public function getId_staj()
  {
    return $this->id_staj;
  }

  /**
   * Set many features have one product. This is the owning side.
   *
   * $id_staj  Many features have one product. This is the owning side.
   *
   * @return  self
   */ 
  public function setId_staj($id_staj)
  {
    $this->id_staj = $id_staj;

    return $this;
  }
}
