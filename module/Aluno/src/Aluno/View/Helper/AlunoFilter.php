<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 30/09/2015
 * Time: 11:35
 */

namespace Aluno\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Aluno\Model\Aluno;

class AlunoFilter extends AbstractHelper
{

    protected $aluno;

    public function __invoke(Aluno $aluno)
    {
        $this->aluno = $aluno;

        return $this;
    }

    //dados do aluno curso
    public function idAluno()
    {
        $result = $this->aluno->id_aluno;

        return $this->view->escapeHtml($result);
    }

    public function nomeAluno()
    {
        $result = $this->aluno->nome_aluno;

        return $this->view->escapeHtml($result);
    }

    public function matriculaAluno()
    {
        $result = $this->aluno->matricula_aluno;

        return $this->view->escapeHtml($result);
    }


    public function cursoAluno()
    {
        $result = $this->aluno->curso_aluno;

        return $this->view->escapeHtml($result);
    }

    public function serieAluno()
    {
        $result = $this->aluno->serie_aluno;

        return $this->view->escapeHtml($result);
    }

    public function materiaAluno()
    {
        $result = $this->aluno->materia_aluno;

        return $this->view->escapeHtml($result);
    }

    public function professorAluno()
    {
        $result = $this->aluno->professor_aluno;

        return $this->view->escapeHtml($result);
    }

    //notas provas
    public function prova1Aluno()
    {
        $result = $this->aluno->prova1 ? $this->aluno->prova1 : 0;

        return $this->view->escapeHtml($result);
    }

    public function prova2Aluno()
    {
        $result = $this->aluno->prova2 ? $this->aluno->prova2 : 0;

        return $this->view->escapeHtml($result);
    }

    public function prova3Aluno()
    {
        $result = $this->aluno->prova3 ? $this->aluno->prova3 : 0;

        return $this->view->escapeHtml($result);
    }

    public function prova4Aluno()
    {
        $result = $this->aluno->prova4 ? $this->aluno->prova4 : 0;

        return $this->view->escapeHtml($result);
    }

    //notas trabalhos
    public function trabalho1Aluno()
    {
        $result = $this->aluno->trabalho1 ? $this->aluno->trabalho1 : 0;

        return $this->view->escapeHtml($result);
    }

    public function trabalho2Aluno()
    {
        $result = $this->aluno->trabalho2 ? $this->aluno->trabalho2 : 0;

        return $this->view->escapeHtml($result);
    }

    public function trabalho3Aluno()
    {
        $result = $this->aluno->trabalho3 ? $this->aluno->trabalho3 : 0;

        return $this->view->escapeHtml($result);
    }

    public function trabalho4Aluno()
    {
        $result = $this->aluno->trabalho4 ? $this->aluno->trabalho4 : 0;

        return $this->view->escapeHtml($result);
    }

    public function FaltasAluno()
    {
        $result = $this->aluno->faltas ? $this->aluno->faltas : 0;

        return $this->view->escapeHtml($result);
    }

    public function TotalNotasAluno()
    {
        $total = $this->aluno->prova1+
            $this->aluno->prova2+
            $this->aluno->prova3+
            $this->aluno->prova4+
            $this->aluno->trabalho1+
            $this->aluno->trabalho2+
            $this->aluno->trabalho3+
            $this->aluno->trabalho4;

        $result = $total;

        return $this->view->escapeHtml($result);
    }

    public function SituacaoAluno()
    {
        $result = $this->aluno->situacao_aluno;
        //$result = 0;

        return $this->view->escapeHtml($result);
    }

    public function dataAtualizacao()
    {
        $result = (new \DateTime($this->aluno->data_atualizacao))->format('d/m/Y - H:i');

        return $this->view->escapeHtml($result);
    }

}