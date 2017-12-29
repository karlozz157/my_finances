<?php

namespace MyFinancesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait FlowAware
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @Assert\NotBlank()
     * @Assert\Date()
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="concept", type="string", length=255)
     */
    private $concept;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     *
     * @ORM\Column(name="unity", type="integer", options={"default": 1})
     */
    private $unity;

    /**
     * @var float
     *
     * @Assert\NotBlank()
     * @Assert\Type("float")
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date 
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = new \DateTime($date);

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        if ($this->date instanceof \DateTime) {
            return $this->date->format('Y-m-d');
        }

        return $this->date;
    }

    /**
     * Set concept
     *
     * @param string $concept
     * @return Expense
     */
    public function setConcept($concept)
    {
        $this->concept = $concept;

        return $this;
    }

    /**
     * Get concept
     *
     * @return string 
     */
    public function getConcept()
    {
        return $this->concept;
    }

    /**
     * Set unity
     *
     * @param integer $unity
     * @return Expense
     */
    public function setUnity($unity)
    {
        $this->unity = $unity;

        return $this;
    }

    /**
     * Get unity
     *
     * @return integer 
     */
    public function getUnity()
    {
        return $this->unity;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Expense
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return ($this->getUnity() * $this->getPrice());
    }
}
