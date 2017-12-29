<?php

namespace MyFinancesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Expense
 *
 * @ORM\Table(name="expenses")
 * @ORM\Entity(repositoryClass="MyFinancesBundle\Repository\ExpenseRepository")
 */
class Expense
{
    use FlowAware;
}
