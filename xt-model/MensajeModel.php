<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 02/11/2015
 * Time: 17:51
 */
class MensajeModel
{
    public function MensajeRegistro($tipo = 1, $mensaje)
    {   //1=Success, 2=Error, 3=Alert
        switch($tipo)
        {
            case 1:
                $tipomsj = "success";
            break;
            case 2:
                $tipomsj = "danger";
            break;
            case 2:
                $tipomsj = "warning";
            break;
        }

        $strmensaje =
            '<div class="alert alert-'. $tipomsj .' alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>' . $mensaje . '</div>';

        return $strmensaje;

    }

}