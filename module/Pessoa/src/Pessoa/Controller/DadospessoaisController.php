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
namespace Pessoa\Controller;

// import ZendMvc
use Zend\Mvc\Controller\AbstractActionController;

// import ZendView
use Zend\View\Model\ViewModel;

// imort ModelPessoaTable com alias
use Pessoa\Model\PessoaTable as ModelPessoa;

// import PessoaForm
use Pessoa\Form\PessoaForm;

// import ModelPessoa
use Pessoa\Model\Pessoa;

class DadospessoaisController extends AbstractActionController
{
    protected $pessoaTable;

    // GET /dadospessoais
    public function indexAction()
    {
        return new ViewModel();
    }

    // GET /dadospessoais
    public function mainAction()
    {
        // colocar parametros da url em um array
        $paramsUrl = [
            'pagina_atual'  => $this->params()->fromQuery('pagina', 1),
            'itens_pagina'  => $this->params()->fromQuery('itens_pagina', 10),
            'coluna_nome'   => $this->params()->fromQuery('coluna_nome', 'nome_pessoa'),
            'coluna_sort'   => $this->params()->fromQuery('coluna_sort', 'ASC'),
            'search'        => $this->params()->fromQuery('search', null),
        ];

        // configuar método de paginação
        $paginacao = $this->getPessoaTable()->fetchPaginator(
            /* $pagina */           $paramsUrl['pagina_atual'],
            /* $itensPagina */      $paramsUrl['itens_pagina'],
            /* $ordem */            "{$paramsUrl['coluna_nome']} {$paramsUrl['coluna_sort']}",
            /* $search */           $paramsUrl['search'],
            /* $itensPaginacao */   5
        );

        // retonar paginação mais os params de url para view
        return new ViewModel(['dadospessoais' => $paginacao] + $paramsUrl);
    }

    // GET /dadospessoais/novo
    public function novoAction()
    {
        return ['formDadosPessoais' => new PessoaForm()];
    }

    // POST /dadospessoais/adicionar
    public function adicionarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new PessoaForm();
            // instancia model dadospessoais com regras de filtros e validações
            $modelPessoa = new Pessoa();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity dadospessoais
            $form->setInputFilter($modelPessoa->getInputFilter());
            // passa para o objeto formulário os dadospessoais vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os dadospessoais à tabela no banco
                // 1 - popular model com valores do formulário
                $modelPessoa->exchangeArray($form->getData());
                // 2 - persistir dadospessoais do model para banco de dadospessoais
                $this->getPessoaTable()->save($modelPessoa);

                // redirecionar para action index no controller dadospessoais
                return $this->redirect()->toRoute('dadospessoais', ['action' => 'main']);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formDadosPessoais', $form)
                    ->setTemplate('pessoa/dadospessoais/novo');
            }
        }
    }

    // GET /dadospessoais/detalhes/id
    public function detalhesAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para dadospessoais
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Dados Pessoais não encotrados!");

            // redirecionar para action index
            return $this->redirect()->toRoute('dadospessoais', ['action' => 'main']);
        }

        try {
            // aqui vai a lógica para pegar os dadospessoais referente ao dadospessoais
            // 1 - solicitar serviço para pegar o model responsável pelo find
            // 2 - solicitar form com dadospessoais desse dadospessoais encontrado
            // formulário com dadospessoais preenchidos

            // lógica cache objeto dadospessoais
            $nome_cache_dados_pessoais_id = "nome_cache_dados_pessoais_{$id}";
            if (!$this->cache()->hasItem($nome_cache_dados_pessoais_id)) {
                $pessoa = $this->getPessoaTable()->find($id);

                $this->cache()->setItem($nome_cache_dados_pessoais_id, $pessoa);
            } else {
                $pessoa = $this->cache()->getItem($nome_cache_dados_pessoais_id);
            }
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('dadospessoais', ['action' => 'main']);
        }

        // dadospessoais eviados para detalhes.phtml
        return (new ViewModel())
            ->setTerminal($this->getRequest()->isXmlHttpRequest())
            ->setVariable('dadospessoais', $pessoa)
            ;
    }

    // GET /dadospessoais/editar/id
    public function editarAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para dadospessoais
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Dados Pessoais não encotrados!");

            // redirecionar para action index
            return $this->redirect()->toRoute('dadospessoais', ['action' => 'main']);
        }

        try {
            // variável com objeto dadospessoais localizado
            $pessoa = (array) $this->getPessoaTable()->find($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('dadospessoais', ['action' => 'main']);
        }

        // objeto form dadospessoais vazio
        $form = new PessoaForm();
        // popula objeto form dadospessoais com objeto model dadospessoais
        $form->setData($pessoa);

        // dadospessoais eviados para editar.phtml
        return ['formDadosPessoais' => $form];
    }

    // POST /dadospessoais/editar/id
    public function atualizarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new PessoaForm();
            // instancia model dadospessoais com regras de filtros e validações
            $modelPessoa = new Pessoa();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity dadospessoais
            $form->setInputFilter($modelPessoa->getInputFilter());
            // passa para o objeto formulário os dadospessoais vindos da submissão
            $form->setData($request->getPost());
            //echo "atualizarAction".$request;die;
            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                echo "isValid";
                // aqui vai a lógica para atualizar os dadospessoais à tabela no banco
                // 1 - popular model com valores do formulário
                $modelPessoa->exchangeArray($form->getData());
                // 2 - atualizar dadospessoais do model para banco de dadospessoais
                $this->getPessoaTable()->update($modelPessoa);

                // adicionar mensagem de sucesso
                $this->flashMessenger()
                    ->addSuccessMessage("Dados Pessoais editado com sucesso");

                $nome_cache_dados_pessoais_id = "nome_cache_dados_pessoais_{$modelPessoa->id_pessoa}";
                if ($this->cache()->hasItem($nome_cache_dados_pessoais_id)) {
                    $this->cache()->removeItem($nome_cache_dados_pessoais_id);
                }

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('dadospessoais', ["action" => "main", "id" => $modelPessoa->id_pessoa]);
            } else { // em caso da validação não seguir o que foi definido

                echo "isValid False";
                // renderiza para action editar com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formDadosPessoais', $form)
                    ->setTemplate('pessoa/dadospessoais/editar');
            }
        }
    }

    // DELETE /dadospessoais/deletar/id
    public function deletarAction()
    {
        // filtra id_pessoa passsado pela url
        $id_pessoa = (int) $this->params()->fromRoute('id', 0);
        //echo "deletarAction ".$id_pessoa;die;
        // se id_pessoa = 0 ou não informado redirecione para dadospessoais
        if (!$id_pessoa) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Dados Pessoais não encotrados!");
        } else {
            // aqui vai a lógica para deletar o dadospessoais no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta dadospessoais
            $this->getPessoaTable()->delete($id_pessoa);

            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Dados Pessoais de ID $id_pessoa deletado com sucesso!");
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('dadospessoais', ['action' => 'main']);
    }

    /**
     * Metodo privado para obter instacia do Model PessoaTable
     *
     * @return PessoaTable
     */
    private function getPessoaTable()
    {
        // adicionar service ModelPessoa a variavel de classe
        if (!$this->pessoaTable) {
            $this->pessoaTable = $this->getServiceLocator()->get('ModelPessoa');
        }

        // return vairavel de classe com service ModelPessoa
        return $this->pessoaTable;
    }

    // GET /dadospessoais/search?query=[nome]
    public function searchAction()
    {
        $nome = $this->params()->fromQuery('query', null);
        if (isset($nome)) {
            $result = $this->getPessoaTable()->search($nome);
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