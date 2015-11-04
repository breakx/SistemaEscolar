<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 30/09/2015
 * Time: 11:35
 */

namespace Materia\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Materia\Model\Materia;

class MateriaFilter extends AbstractHelper
{

    protected $materia;

    public function __invoke(Materia $materia)
    {
        $this->materia = $materia;

        return $this;
    }

    public function idMateria()
    {
        $result = $this->materia->id_materia;

        return $this->view->escapeHtml($result);
    }

    public function nomeMateria()
    {
        $result = $this->materia->nome_materia;

        return $this->view->escapeHtml($result);
    }

    public function Ano()
    {
        //$result = (new \DateTime($this->materia->ano))->format('Y');
        $result = $this->materia->ano;

        return $this->view->escapeHtml($result);
    }

    public function tipoMateria()
    {
        $result = $this->materia->tipo_materia;

        return $this->view->escapeHtml($result);
    }

    public function nomeProfessor()
    {
        $result = $this->materia->nome_professor;

        return $this->view->escapeHtml($result);
    }
}