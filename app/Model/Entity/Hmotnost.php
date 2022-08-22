<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hmotnost")
 */
class Hmotnost
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
     * @var int
     * 
     * @ORM\Column(name="hmotnost", type="integer")
     */
    private $hmotnost;

    /**
     *
     * 
     * @ORM\Column(name="datum", type="date")
     */
    private $datum;

    /**
     * 
     * 
     * @ORM\ManyToOne(targetEntity="Zvire")
     * @ORM\JoinColumn(name="id_zvirete", referencedColumnName="id", onDelete="CASCADE")
     */
    private $id_zvirete;

    /**
     * Get the value of hmotnost
     *
     * @return  int
     */ 
    public function getHmotnost()
    {
        return $this->hmotnost;
    }

    /**
     * Set the value of hmotnost
     *
     * @param  int  $hmotnost
     *
     * @return  self
     */ 
    public function setHmotnost(int $hmotnost)
    {
        $this->hmotnost = $hmotnost;

        return $this;
    }

    /**
     * Get the value of datum
     */ 
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * Set the value of datum
     *
     * @return  self
     */ 
    public function setDatum($datum)
    {
        $this->datum = $datum;

        return $this;
    }

    /**
     * Get the value of id_zvirete
     *
     * @return  int
     */ 
    public function getId_zvirete()
    {
        return $this->id_zvirete;
    }

    /**
     * Set the value of id_zvirete
     *
     * 
     *
     * @return  self
     */ 
    public function setId_zvirete($id_zvirete)
    {
        $this->id_zvirete = $id_zvirete;

        return $this;
    }
}
