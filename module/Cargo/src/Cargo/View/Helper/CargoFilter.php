<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 30/09/2015
 * Time: 11:35
 */

namespace Cargo\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Cargo\Model\Cargo;

class CargoFilter extends AbstractHelper
{

    protected $cargo;

    public function __invoke(Cargo $cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    public function idCargo()
    {
        $result = $this->cargo->id_cargo;

        return $this->view->escapeHtml($result);
    }

    public function nomeCargo()
    {
        $result = $this->cargo->nome_cargo;

        return $this->view->escapeHtml($result);
    }

}