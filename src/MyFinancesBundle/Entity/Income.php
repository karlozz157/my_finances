<?php

namespace MyFinancesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Income
 *
 * @ORM\Table(name="incomes")
 * @ORM\Entity(repositoryClass="MyFinancesBundle\Repository\IncomeRepository")
 */
class Income
{
    use FlowAware;
}
