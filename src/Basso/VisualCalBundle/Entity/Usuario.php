<?php

namespace Basso\VisualCalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Basso\GuardBundle\Entity\Usuario as BaseUser;

/**
 * Usuario
 *
 * @ORM\Table(name="neosys.usuarios")
 * @ORM\Entity(repositoryClass="Basso\VisualCalBundle\Repository\UsuarioRepository")
 */
class Usuario extends BaseUser
{    
    public function __construct() {
        parent::__construct();
    }

}

