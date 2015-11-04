<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 30/09/2015
 * Time: 11:35
 */

namespace Usuario\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Usuario\Model\Usuario;

class UsuarioFilter extends AbstractHelper
{

    protected $usuario;

    public function __invoke(Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function idUsuario()
    {
        $result = $this->usuario->id_usuario;

        return $this->view->escapeHtml($result);
    }

    public function Matricula()
    {
        $result = $this->usuario->matricula;

        return $this->view->escapeHtml($result);
    }

    public function Senha()
    {
        $result = $this->usuario->senha;

        return $this->view->escapeHtml($result);
    }
}