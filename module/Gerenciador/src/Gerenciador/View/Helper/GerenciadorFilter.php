<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 30/09/2015
 * Time: 11:35
 */

namespace Gerenciador\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Gerenciador\Model\Gerenciador;

class GerenciadorFilter extends AbstractHelper
{

    protected $gerenciador;

    public function __invoke(Gerenciador $gerenciador)
    {
        $this->gerenciador = $gerenciador;

        return $this;
    }

    public function idGerenciador()
    {
        $result = $this->gerenciador->id_gerenciador;

        return $this->view->escapeHtml($result);
    }

    public function nomeGerenciador()
    {
        $result = $this->gerenciador->nome_gerenciador;

        return $this->view->escapeHtml($result);
    }
}