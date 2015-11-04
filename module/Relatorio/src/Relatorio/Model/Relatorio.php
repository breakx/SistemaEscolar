<?php
/**
 * Created by PhpStorm.
 * User: LK
 * Date: 05/10/2015
 * Time: 19:34
 */

namespace Relatorio\Model;

class Relatorio
{
    public $id;
    public $nome;
    public $telefone_principal;
    public $telefone_secundario;
    public $tipo_usuario;
    public $data_criacao;
    public $data_atualizacao;
    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->id                   = (!empty($data['id'])) ? $data['id'] : null;
        $this->nome                 = (!empty($data['nome_pessoa'])) ? $data['nome_pessoa'] : null;
        $this->telefone_principal   = (!empty($data['telefone_principal'])) ? $data['telefone_principal'] : null;
        $this->telefone_secundario  = (!empty($data['telefone_secundario'])) ? $data['telefone_secundario'] : null;
        $this->tipo_usuario         = (!empty($data['tipo_usuario'])) ? $data['tipo_usuario'] : null;
        $this->data_criacao         = (!empty($data['data_criacao'])) ? $data['data_criacao'] : null;
        $this->data_atualizacao     = (!empty($data['data_atualizacao'])) ? $data['data_atualizacao'] : null;
    }
}