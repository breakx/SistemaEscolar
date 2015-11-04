<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 26/09/2015
 * Time: 22:18
 */

/**
 * namespace de localizacao do nosso controller
 */
namespace Curso\Controller;

// import ZendMvc
use Zend\Mvc\Controller\AbstractActionController;

// import ZendView
use Zend\View\Model\ViewModel;

// imort ModelCursoTable com alias
use Curso\Model\CursoTable as ModelCurso;

// import CursoForm
use Curso\Form\CursoForm;

// import ModelCurso
use Curso\Model\Curso;

class CursosController extends AbstractActionController
{
    protected $cursoTable;

    // GET /cursos
    public function indexAction()
    {
        return new ViewModel();
    }

    // GET /cursos
    public function mainAction()
    {
        // colocar parametros da url em um array
        $paramsUrl = [
            'pagina_atual'  => $this->params()->fromQuery('pagina', 1),
            'itens_pagina'  => $this->params()->fromQuery('itens_pagina', 10),
            'coluna_nome'   => $this->params()->fromQuery('coluna_nome', 'nome_curso'),
            'coluna_sort'   => $this->params()->fromQuery('coluna_sort', 'ASC'),
            'search'        => $this->params()->fromQuery('search', null),
        ];

        // configuar método de paginação
        $paginacao = $this->getCursoTable()->fetchPaginator(
            /* $pagina */           $paramsUrl['pagina_atual'],
            /* $itensPagina */      $paramsUrl['itens_pagina'],
            /* $ordem */            "{$paramsUrl['coluna_nome']} {$paramsUrl['coluna_sort']}",
            /* $search */           $paramsUrl['search'],
            /* $itensPaginacao */   5
        );

        // retonar paginação mais os params de url para view
        return new ViewModel(['cursos' => $paginacao] + $paramsUrl);
    }

    // GET /cursos/novo
    public function novoAction()
    {
        return ['formCursos' => new CursoForm()];
    }

    // POST /curso/adicionar
    public function adicionarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new CursoForm();
            // instancia model cursos com regras de filtros e validações
            $modelCurso = new Curso();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity cursos
            $form->setInputFilter($modelCurso->getInputFilter());
            // passa para o objeto formulário os curso vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os cursos à tabela no banco
                // 1 - popular model com valores do formulário
                $modelCurso->exchangeArray($form->getData());
                // 2 - persistir curso do model para banco de curso
                $this->getCursoTable()->save($modelCurso);

                // redirecionar para action index no controller curso
                return $this->redirect()->toRoute('cursos', ['action' => 'main']);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formCursos', $form)
                    ->setTemplate('curso/cursos/novo');
            }
        }
    }

    // GET /cursos/detalhes/id
    public function detalhesAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para cursos
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Curso não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('cursos', ['action' => 'main']);
        }

        try {
            // aqui vai a lógica para pegar os curso referente ao curso
            // 1 - solicitar serviço para pegar o model responsável pelo find
            // 2 - solicitar form com curso desse curso encontrado
            // formulário com curso preenchidos

            // lógica cache objeto curso
            $nome_cache_curso_id = "nome_cache_curso_{$id}";
            if (!$this->cache()->hasItem($nome_cache_curso_id)) {
                $curso = $this->getCursoTable()->find($id);

                $this->cache()->setItem($nome_cache_curso_id, $curso);
            } else {
                $curso = $this->cache()->getItem($nome_cache_curso_id);
            }
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('cursos', ['action' => 'main']);
        }

        // curso eviados para detalhes.phtml
        return (new ViewModel())
            ->setTerminal($this->getRequest()->isXmlHttpRequest())
            ->setVariable('cursos', $curso)
            ;
    }

    // GET /curso/editar/id
    public function editarAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para curso
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Curso não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('cursos', ['action' => 'main']);
        }

        try {
            // variável com objeto curso localizado
            $curso = (array) $this->getCursoTable()->find($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('cursos', ['action' => 'main']);
        }

        // objeto form curso vazio
        $form = new CursoForm();
        // popula objeto form curso com objeto model curso
        $form->setData($curso);

        // curso eviados para editar.phtml
        return ['formCursos' => $form];
    }

    // POST /curso/editar/id
    public function atualizarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new CursoForm();
            // instancia model curso com regras de filtros e validações
            $modelCurso = new Curso();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity curso
            $form->setInputFilter($modelCurso->getInputFilter());
            // passa para o objeto formulário os curso vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para atualizar os curso à tabela no banco
                // 1 - popular model com valores do formulário
                $modelCurso->exchangeArray($form->getData());
                // 2 - atualizar curso do model para banco de curso
                $this->getCursoTable()->update($modelCurso);

                // adicionar mensagem de sucesso
                $this->flashMessenger()
                    ->addSuccessMessage("Curso editado com sucesso");

                $nome_cache_curso_id = "nome_cache_curso_{$modelCurso->id_curso}";
                if ($this->cache()->hasItem($nome_cache_curso_id)) {
                    $this->cache()->removeItem($nome_cache_curso_id);
                }

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('cursos', ["action" => "main", "id" => $modelCurso->id_curso]);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action editar com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formCursos', $form)
                    ->setTemplate('curso/cursos/editar');
            }
        }
    }

    // DELETE /curso/deletar/id
    public function deletarAction()
    {
        // filtra id_curso passsado pela url
        $id_curso = (int) $this->params()->fromRoute('id', 0);

        // se id_curso = 0 ou não informado redirecione para curso
        if (!$id_curso) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Curso não encotrado" .$id_curso);
        } else {
            // aqui vai a lógica para deletar o curso no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta curso
            $this->getCursoTable()->delete($id_curso);

            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Curso de ID $id_curso deletado com sucesso");
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('cursos', ['action' => 'main']);
    }

    /**
     * Metodo privado para obter instacia do Model CursoTable
     *
     * @return CursoTable
     */
    private function getCursoTable()
    {
        // adicionar service ModelCurso a variavel de classe
        if (!$this->cursoTable) {
            $this->cursoTable = $this->getServiceLocator()->get('ModelCurso');
        }

        // return vairavel de classe com service ModelCurso
        return $this->cursoTable;
    }

    // GET /cursos/search?query=[nome]
    public function searchAction()
    {
        $nome = $this->params()->fromQuery('query', null);
        if (isset($nome)) {
            $result = $this->getCursoTable()->search($nome);
        } else  {
            $result = [];
        }

        return new \Zend\View\Model\JsonModel($result);
    }

    /**
     * action sobre
     * @return \Zend\View\Model\ViewModel
     */
    public function sobreAction()
    {
        return new ViewModel();
    }
}