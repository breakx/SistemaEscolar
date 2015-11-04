<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 30/09/2015
 * Time: 11:35
 */

namespace Curso\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Curso\Model\Curso;

class CursoFilter extends AbstractHelper
{

    protected $curso;

    public function __invoke(Curso $curso)
    {
        $this->curso = $curso;

        return $this;
    }

    public function idCurso()
    {
        $result = $this->curso->id_curso;

        return $this->view->escapeHtml($result);
    }

    public function nomeCurso()
    {
        $result = $this->curso->nome_curso;

        return $this->view->escapeHtml($result);
    }

    public function turnoCurso()
    {
        $result = $this->curso->turno;

        return $this->view->escapeHtml($result);
    }

    public function tipoCurso()
    {
        $result = $this->curso->tipo;

        return $this->view->escapeHtml($result);
    }
}