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
namespace Aluno\Controller;

// import ZendMvc
use Zend\Mvc\Controller\AbstractActionController;

// import ZendView
use Zend\View\Model\ViewModel;

// imort ModelAlunoTable com alias
use Aluno\Model\AlunoTable as ModelAluno;

// import AlunoForm
use Aluno\Form\AlunoForm;

// import ModelAluno
use Aluno\Model\Aluno;

class AlunosController extends AbstractActionController
{
    protected $alunoTable;

    // GET /alunos
    public function indexAction()
    {
        return new ViewModel();
    }

    // GET /alunos
    public function mainAction()
    {
        // colocar parametros da url em um array
        $paramsUrl = [
            'pagina_atual'  => $this->params()->fromQuery('pagina', 1),
            'itens_pagina'  => $this->params()->fromQuery('itens_pagina', 10),
            'coluna_nome'   => $this->params()->fromQuery('coluna_nome', 'nome_aluno'),
            'coluna_sort'   => $this->params()->fromQuery('coluna_sort', 'ASC'),
            'search'        => $this->params()->fromQuery('search', null),
        ];

        // configuar método de paginação
        $paginacao = $this->getAlunoTable()->fetchPaginator(
            /* $pagina */           $paramsUrl['pagina_atual'],
            /* $itensPagina */      $paramsUrl['itens_pagina'],
            /* $ordem */            "{$paramsUrl['coluna_nome']} {$paramsUrl['coluna_sort']}",
            /* $search */           $paramsUrl['search'],
            /* $itensPaginacao */   5
        );

        // retonar paginação mais os params de url para view
        return new ViewModel(['alunos' => $paginacao] + $paramsUrl);
    }

    // GET /alunos/novo
    public function novoAction()
    {
        return ['formAlunos' => new AlunoForm()];
    }

    // POST /alunos/adicionar
    public function adicionarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new AlunoForm();
            // instancia model alunos com regras de filtros e validações
            $modelAluno = new Aluno();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity alunos
            $form->setInputFilter($modelAluno->getInputFilter());
            // passa para o objeto formulário os alunos vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os alunos à tabela no banco
                // 1 - popular model com valores do formulário
                $modelAluno->exchangeArray($form->getData());
                // 2 - persistir alunos do model para banco de alunos
                $this->getAlunoTable()->save($modelAluno);

                // redirecionar para action index no controller alunos
                return $this->redirect()->toRoute('alunos', ['action' => 'main']);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formAlunos', $form)
                    ->setTemplate('aluno/alunos/novo');
            }
        }
    }

    // GET /alunos/detalhes/id
    public function detalhesAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para alunos
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Aluno não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('alunos', ['action' => 'main']);
        }

        try {
            // aqui vai a lógica para pegar os alunos referente ao alunos
            // 1 - solicitar serviço para pegar o model responsável pelo find
            // 2 - solicitar form com alunos desse alunos encontrado
            // formulário com alunos preenchidos

            // lógica cache objeto alunos
            $nome_cache_aluno_id = "nome_cache_aluno_{$id}";
            if (!$this->cache()->hasItem($nome_cache_aluno_id)) {
                $aluno = $this->getAlunoTable()->find($id);

                $this->cache()->setItem($nome_cache_aluno_id, $aluno);
            } else {
                $aluno = $this->cache()->getItem($nome_cache_aluno_id);
            }
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('alunos', ['action' => 'main']);
        }

        // alunos eviados para detalhes.phtml
        return (new ViewModel())
            ->setTerminal($this->getRequest()->isXmlHttpRequest())
            ->setVariable('alunos', $aluno)
            ;
    }

    // GET /alunos/editar/id
    public function editarAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para alunos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Aluno não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('alunos', ['action' => 'main']);
        }

        try {
            // variável com objeto alunos localizado
            $aluno = (array) $this->getAlunoTable()->find($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('alunos', ['action' => 'main']);
        }

        // objeto form aluno vazio
        $form = new AlunoForm();
        // popula objeto form alunos com objeto model alunos
        $form->setData($aluno);

        // alunos eviados para editar.phtml
        return ['formAlunos' => $form];
    }

    // POST /alunos/editar/id
    public function atualizarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new AlunoForm();
            // instancia model alunos com regras de filtros e validações
            $modelAluno = new Aluno();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity alunos
            $form->setInputFilter($modelAluno->getInputFilter());
            // passa para o objeto formulário os alunos vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para atualizar os alunos à tabela no banco
                // 1 - popular model com valores do formulário
                $modelAluno->exchangeArray($form->getData());
                // 2 - atualizar alunos do model para banco de alunos
                $this->getAlunoTable()->update($modelAluno);

                // adicionar mensagem de sucesso
                $this->flashMessenger()
                    ->addSuccessMessage("Aluno editado com sucesso");

                $nome_cache_aluno_id = "nome_cache_aluno_{$modelAluno->id_aluno}";
                if ($this->cache()->hasItem($nome_cache_aluno_id)) {
                    $this->cache()->removeItem($nome_cache_aluno_id);
                }

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('alunos', ["action" => "main", "id" => $modelAluno->id_aluno]);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action editar com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formAlunos', $form)
                    ->setTemplate('aluno/alunos/editar');
            }
        }
    }

    // DELETE /alunos/deletar/id
    public function deletarAction()
    {
        // filtra id_aluno passsado pela url
        $id_aluno = (int) $this->params()->fromRoute('id', 0);

        // se id_aluno = 0 ou não informado redirecione para alunos
        if (!$id_aluno) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Aluno não encotrado" .$id_aluno);
        } else {
            // aqui vai a lógica para deletar o alunos no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta alunos
            $this->getAlunoTable()->delete($id_aluno);

            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Aluno de ID $id_aluno deletado com sucesso");
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('alunos', ['action' => 'main']);
    }

    /**
     * Metodo privado para obter instacia do Model AlunoTable
     *
     * @return AlunoTable
     */
    private function getAlunoTable()
    {
        // adicionar service ModelAluno a variavel de classe
        if (!$this->alunoTable) {
            $this->alunoTable = $this->getServiceLocator()->get('ModelAluno');
        }

        // return vairavel de classe com service ModelAluno
        return $this->alunoTable;
    }

    // GET /alunos/search?query=[nome]
    public function searchAction()
    {
        $nome = $this->params()->fromQuery('query', null);
        if (isset($nome)) {
            $result = $this->getAlunoTable()->search($nome);
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