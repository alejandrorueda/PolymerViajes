<?php

use Base\Perfil as BasePerfil;

/**
 * Skeleton subclass for representing a row from the 'perfil' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Perfil extends BasePerfil
{

  public function obtenerPerfil($usuario){
    $perfil = PerfilQuery::create()->filterByIdperfil($usuario->getIdperfil())->findOne();
     return $perfil;

  }

}
