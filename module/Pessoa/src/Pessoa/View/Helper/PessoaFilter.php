<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 30/09/2015
 * Time: 11:35
 */

namespace Pessoa\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Pessoa\Model\Pessoa;

class PessoaFilter extends AbstractHelper
{

    protected $pessoa;

    public function __invoke(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;

        return $this;
    }

    public function idPessoa()
    {
        $result = $this->pessoa->id_pessoa;

        return $this->view->escapeHtml($result);
    }

    public function nomeSobrenome()
    {
        $partes_nome = explode(" ", $this->nomeCompleto());
        $result = null;

        if (count($partes_nome) <= 2) {
            $result = join($partes_nome, " ");
        } else {
            $result = "{$partes_nome[0]} {$partes_nome[1]} ...";
        }

        return $this->view->escapeHtml($result);
    }

    public function nomeCompleto()
    {
        $result = $this->pessoa->nome_pessoa;

        return $this->view->escapeHtml($result);
    }

    public function quantidadeTelefones()
    {
        $result = ((int) !empty($this->pessoa->telefone_principal)) + ((int) !empty($this->pessoa->telefone_secundario));

        return $this->view->escapeHtml($result);
    }

    public function dataNasc()
    {
        $result = (new \DateTime($this->pessoa->data_nasc))->format('d/m/Y - H:i');

        return $this->view->escapeHtml($result);
    }

    public function dataAtualizacao()
    {
        $result = (new \DateTime($this->pessoa->data_atualizacao))->format('d/m/Y - H:i');

        return $this->view->escapeHtml($result);
    }

    public function telefonePrincipal()
    {
        $result = $this->pessoa->telefone_principal ? $this->pessoa->telefone_principal : 'Sem Registro';

        return $this->view->escapeHtml($result);
    }

    public function telefoneSecundario()
    {
        $result = $this->pessoa->telefone_secundario ? $this->pessoa->telefone_secundario : 'Sem Registro';

        return $this->view->escapeHtml($result);
    }

    public function cpf()
    {
        $result = $this->pessoa->cpf;

        return $this->view->escapeHtml($result);
    }

}