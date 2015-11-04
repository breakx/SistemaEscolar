<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 30/09/2015
 * Time: 11:35
 */

namespace Funcionario\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Funcionario\Model\Funcionario;

class FuncionarioFilter extends AbstractHelper
{

    protected $funcionario;

    public function __invoke(Funcionario $funcionario)
    {
        $this->funcionario = $funcionario;

        return $this;
    }

    public function idFuncionario()
    {
        $result = $this->funcionario->id_funcionario;

        return $this->view->escapeHtml($result);
    }

    public function nomeFuncionario()
    {
        $result = $this->funcionario->nome_funcionario;

        return $this->view->escapeHtml($result);
    }

    public function cargoFuncionario()
    {
        $result = $this->funcionario->cargo_funcionario;

        return $this->view->escapeHtml($result);
    }

    public function especiadadeFuncionario()
    {
        $result = $this->funcionario->especialidade;

        return $this->view->escapeHtml($result);
    }

    public function formacaoFuncionario()
    {
        $result = $this->funcionario->formacao;

        return $this->view->escapeHtml($result);
    }
}