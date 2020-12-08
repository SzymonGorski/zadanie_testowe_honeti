<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Person
 *
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 * @ORM\Table(name="person")
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $login;

    /**
     * @ORM\Column(name="l_name", type="string", length=100, nullable=false)
     */
    private $lastname;

    /**
     * @ORM\Column(name="f_name", type="string", length=100, nullable=false)
     */
    private $firstname;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonLikeProduct", mappedBy="person")
     */
    private $personLikeProduct;

    const STATE_ACTIVE = 1;
    const STATE_BANNED = 2;
    const STATE_DELETED = 3;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    public function getStateName()
    {
        switch ($this->state){
            case self::STATE_ACTIVE:
                return 'Aktywny';
            case self::STATE_BANNED:
                return 'Zbanowany';
            case self::STATE_DELETED:
                return 'Usunięty';
        }
    }

    /**
     * @return mixed
     */
    public function getPersonLikeProduct()
    {
        return $this->personLikeProduct;
    }
}