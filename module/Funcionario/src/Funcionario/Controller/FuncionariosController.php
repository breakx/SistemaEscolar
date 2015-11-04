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
namespace Funcionario\Controller;

// import ZendMvc
use Zend\Mvc\Controller\AbstractActionController;

// import ZendView
use Zend\View\Model\ViewModel;

// imort ModelFuncionarioTable com alias
use Funcionario\Model\FuncionarioTable as ModelFuncionario;

// import FuncionarioForm
use Funcionario\Form\FuncionarioForm;

// import ModelFuncionario
use Funcionario\Model\Funcionario;

class FuncionariosController extends AbstractActionController
{
    protected $funcionarioTable;

    // GET /funcionario
    public function indexAction()
    {
        return new ViewModel();
    }

    // GET /funcionario
    public function mainAction()
    {
        // colocar parametros da url em um array
        $paramsUrl = [
            'pagina_atual'  => $this->params()->fromQuery('pagina', 1),
            'itens_pagina'  => $this->params()->fromQuery('itens_pagina', 10),
            'coluna_nome'   => $this->params()->fromQuery('coluna_nome', 'nome_funcionario'),
            'coluna_sort'   => $this->params()->fromQuery('coluna_sort', 'ASC'),
            'search'        => $this->params()->fromQuery('search', null),
        ];

        // configuar método de paginação
        $paginacao = $this->getFuncionarioTable()->fetchPaginator(
            /* $pagina */           $paramsUrl['pagina_atual'],
            /* $itensPagina */      $paramsUrl['itens_pagina'],
            /* $ordem */            "{$paramsUrl['coluna_nome']} {$paramsUrl['coluna_sort']}",
            /* $search */           $paramsUrl['search'],
            /* $itensPaginacao */   5
        );

        // retonar paginação mais os params de url para view
        return new ViewModel(['funcionarios' => $paginacao] + $paramsUrl);
    }

    // GET /funcionarios/novo
    public function novoAction()
    {
        return ['formFuncionarios' => new FuncionarioForm()];
    }

    // POST /funcionario/adicionar
    public function adicionarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new FuncionarioForm();
            // instancia model funcionarios com regras de filtros e validações
            $modelFuncionario = new Funcionario();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity funcionarios
            $form->setInputFilter($modelFuncionario->getInputFilter());
            // passa para o objeto formulário os funcionarios vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                echo 'isValid';//die;
                // aqui vai a lógica para adicionar os funcionarios à tabela no banco
                // 1 - popular model com valores do formulário
                $modelFuncionario->exchangeArray($form->getData());
                // 2 - persistir funcionarios do model para banco de funcionarios
                $this->getFuncionarioTable()->save($modelFuncionario);

                // redirecionar para action index no controller funcionarios
                return $this->redirect()->toRoute('funcionarios', ['action' => 'main']);
            } else { // em caso da validação não seguir o que foi definido

                echo 'notisValid';//die;
                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formFuncionarios', $form)
                    ->setTemplate('funcionario/funcionarios/novo');
            }
        }
    }

    // GET /funcionarios/detalhes/id
    public function detalhesAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para funcionarios
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Funcionario não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('funcionario', ['action' => 'main']);
        }

        try {
            // aqui vai a lógica para pegar os funcionario referente ao funcionario
            // 1 - solicitar serviço para pegar o model responsável pelo find
            // 2 - solicitar form com funcionario desse funcionario encontrado
            // formulário com funcionarios preenchidos

            // lógica cache objeto funcionario
            $nome_cache_funcionario_id = "nome_cache_funcionario_{$id}";
            if (!$this->cache()->hasItem($nome_cache_funcionario_id)) {
                $funcionario = $this->getFuncionarioTable()->find($id);

                $this->cache()->setItem($nome_cache_funcionario_id, $funcionario);
            } else {
                $funcionario = $this->cache()->getItem($nome_cache_funcionario_id);
            }
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('funcionarios', ['action' => 'main']);
        }

        // funcionarios eviados para detalhes.phtml
        return (new ViewModel())
            ->setTerminal($this->getRequest()->isXmlHttpRequest())
            ->setVariable('funcionarios', $funcionario)
            ;
    }

    // GET /funcionarios/editar/id
    public function editarAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para funcionarios
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Funcionario não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('funcionarios', ['action' => 'main']);
        }

        try {
            // variável com objeto funcionarios localizado
            $funcionario = (array) $this->getFuncionarioTable()->find($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('funcionarios', ['action' => 'main']);
        }

        // objeto form funcionarios vazio
        $form = new FuncionarioForm();
        // popula objeto form funcionario com objeto model funcionario
        $form->setData($funcionario);

        // funcionario eviados para editar.phtml
        return ['formFuncionarios' => $form];
    }

    // POST /funcionario/editar/id
    public function atualizarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new FuncionarioForm();
            // instancia model funcionario com regras de filtros e validações
            $modelFuncionario = new Funcionario();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity funcionario
            $form->setInputFilter($modelFuncionario->getInputFilter());
            // passa para o objeto formulário os funcionarios vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para atualizar os funcionarios à tabela no banco
                // 1 - popular model com valores do formulário
                $modelFuncionario->exchangeArray($form->getData());
                // 2 - atualizar funcionarios do model para banco de funcionarios
                $this->getFuncionarioTable()->update($modelFuncionario);

                // adicionar mensagem de sucesso
                $this->flashMessenger()
                    ->addSuccessMessage("Funcionario editado com sucesso");

                $nome_cache_funcionario_id = "nome_cache_funcionario_{$modelFuncionario->id_funcionario}";
                if ($this->cache()->hasItem($nome_cache_funcionario_id)) {
                    $this->cache()->removeItem($nome_cache_funcionario_id);
                }

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('funcionarios', ["action" => "main", "id" => $modelFuncionario->id_funcionario]);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action editar com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formFuncionarios', $form)
                    ->setTemplate('funcionario/funcionarios/editar');
            }
        }
    }

    // DELETE /funcionario/deletar/id
    public function deletarAction()
    {
        // filtra id_funcionario passsado pela url
        $id_funcionario = (int) $this->params()->fromRoute('id', 0);

        // se id_funcionario = 0 ou não informado redirecione para funcionarios
        if (!$id_funcionario) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Funcionario não encotrado" .$id_funcionario);
        } else {
            // aqui vai a lógica para deletar o funcionarios no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta funcionarios
            $this->getFuncionarioTable()->delete($id_funcionario);

            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Funcionario de ID $id_funcionario deletado com sucesso");
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('funcionarios', ['action' => 'main']);
    }

    /**
     * Metodo privado para obter instacia do Model FuncionarioTable
     *
     * @return FuncionarioTable
     */
    private function getFuncionarioTable()
    {
        // adicionar service ModelFuncionario a variavel de classe
        if (!$this->funcionarioTable) {
            $this->funcionarioTable = $this->getServiceLocator()->get('ModelFuncionario');
        }

        // return vairavel de classe com service ModelFuncionario
        return $this->funcionarioTable;
    }

    // GET /funcionarios/search?query=[nome]
    public function searchAction()
    {
        $nome = $this->params()->fromQuery('query', null);
        if (isset($nome)) {
            $result = $this->getFuncionarioTable()->search($nome);
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