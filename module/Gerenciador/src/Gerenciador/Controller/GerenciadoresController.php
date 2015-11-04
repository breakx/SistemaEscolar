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
namespace Gerenciador\Controller;

// import ZendMvc
use Zend\Mvc\Controller\AbstractActionController;

// import ZendView
use Zend\View\Model\ViewModel;

// imort ModelGerenciadorTable com alias
use Gerenciador\Model\GerenciadorTable as ModelGerenciador;

// import GerenciadorForm
use Gerenciador\Form\GerenciadorForm;

// import ModelGerenciador
use Gerenciador\Model\Gerenciador;

class GerenciadoresController extends AbstractActionController
{
    protected $gerenciadorTable;

    // GET /gerenciadores
    public function indexAction()
    {
        return new ViewModel();
    }

    // GET /gerenciadores
    public function mainAction()
    {
        // colocar parametros da url em um array
        $paramsUrl = [
            'pagina_atual'  => $this->params()->fromQuery('pagina', 1),
            'itens_pagina'  => $this->params()->fromQuery('itens_pagina', 10),
            'coluna_nome'   => $this->params()->fromQuery('coluna_nome', 'nome_gerenciador'),
            'coluna_sort'   => $this->params()->fromQuery('coluna_sort', 'ASC'),
            'search'        => $this->params()->fromQuery('search', null),
        ];

        // configuar método de paginação
        $paginacao = $this->getGerenciadorTable()->fetchPaginator(
            /* $pagina */           $paramsUrl['pagina_atual'],
            /* $itensPagina */      $paramsUrl['itens_pagina'],
            /* $ordem */            "{$paramsUrl['coluna_nome']} {$paramsUrl['coluna_sort']}",
            /* $search */           $paramsUrl['search'],
            /* $itensPaginacao */   5
        );

        // retonar paginação mais os params de url para view
        return new ViewModel(['gerenciadores' => $paginacao] + $paramsUrl);
    }

    // GET /gerenciadores/novo
    public function novoAction()
    {
        return ['formGerenciadores' => new GerenciadorForm()];
    }

    // POST /gerenciadores/adicionar
    public function adicionarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new GerenciadorForm();
            // instancia model gerenciadores com regras de filtros e validações
            $modelGerenciador = new Gerenciador();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity gerenciadores
            $form->setInputFilter($modelGerenciador->getInputFilter());
            // passa para o objeto formulário os gerenciadores vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os gerenciadores à tabela no banco
                // 1 - popular model com valores do formulário
                $modelGerenciador->exchangeArray($form->getData());
                // 2 - persistir gerenciadores do model para banco de gerenciadores
                $this->getGerenciadorTable()->save($modelGerenciador);

                // redirecionar para action index no controller gerenciadores
                return $this->redirect()->toRoute('gerenciadores', ['action' => 'main']);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formGerenciadores', $form)
                    ->setTemplate('gerenciador/gerenciadores/novo');
            }
        }
    }

    // GET /gerenciadores/detalhes/id
    public function detalhesAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para gerenciadores
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Gerenciador não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('gerenciadores', ['action' => 'main']);
        }

        try {
            // aqui vai a lógica para pegar os gerenciadores referente ao gerenciadores
            // 1 - solicitar serviço para pegar o model responsável pelo find
            // 2 - solicitar form com gerenciadores desse gerenciadores encontrado
            // formulário com gerenciadores preenchidos

            // lógica cache objeto gerenciadores
            $nome_cache_gerenciador_id = "nome_cache_gerenciador_{$id}";
            if (!$this->cache()->hasItem($nome_cache_gerenciador_id)) {
                $gerenciador = $this->getGerenciadorTable()->find($id);

                $this->cache()->setItem($nome_cache_gerenciador_id, $gerenciador);
            } else {
                $gerenciador = $this->cache()->getItem($nome_cache_gerenciador_id);
            }
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('gerenciadores', ['action' => 'main']);
        }

        // gerenciadores eviados para detalhes.phtml
        return (new ViewModel())
            ->setTerminal($this->getRequest()->isXmlHttpRequest())
            ->setVariable('gerenciadores', $gerenciador)
            ;
    }

    // GET /gerenciadores/editar/id
    public function editarAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para gerenciadores
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Gerenciador não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('gerenciadores', ['action' => 'main']);
        }

        try {
            // variável com objeto gerenciadores localizado
            $gerenciador = (array) $this->getGerenciadorTable()->find($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('gerenciadores', ['action' => 'main']);
        }

        // objeto form gerenciadores vazio
        $form = new GerenciadorForm();
        // popula objeto form gerenciadores com objeto model gerenciadores
        $form->setData($gerenciador);

        // gerenciadores eviados para editar.phtml
        return ['formGerenciadores' => $form];
    }

    // POST /gerenciadores/editar/id
    public function atualizarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new GerenciadorForm();
            // instancia model gerenciadores com regras de filtros e validações
            $modelGerenciador = new Gerenciador();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity gerenciadores
            $form->setInputFilter($modelGerenciador->getInputFilter());
            // passa para o objeto formulário os gerenciadores vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para atualizar os gerenciadores à tabela no banco
                // 1 - popular model com valores do formulário
                $modelGerenciador->exchangeArray($form->getData());
                // 2 - atualizar gerenciadores do model para banco de gerenciadores
                $this->getGerenciadorTable()->update($modelGerenciador);

                // adicionar mensagem de sucesso
                $this->flashMessenger()
                    ->addSuccessMessage("Gerenciador editado com sucesso");

                $nome_cache_gerenciador_id = "nome_cache_gerenciador_{$modelGerenciador->id_gerenciador}";
                if ($this->cache()->hasItem($nome_cache_gerenciador_id)) {
                    $this->cache()->removeItem($nome_cache_gerenciador_id);
                }

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('gerenciadores', ["action" => "main", "id" => $modelGerenciador->id_gerenciador]);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action editar com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formGerenciadores', $form)
                    ->setTemplate('gerenciador/gerenciadores/editar');
            }
        }
    }

    // DELETE /gerenciadores/deletar/id
    public function deletarAction()
    {
        // filtra id_gerenciador passsado pela url
        $id_gerenciador = (int) $this->params()->fromRoute('id', 0);

        // se id_gerenciador = 0 ou não informado redirecione para gerenciadores
        if (!$id_gerenciador) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Gerenciador não encotrado" .$id_gerenciador);
        } else {
            // aqui vai a lógica para deletar o gerenciador no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta gerenciador
            $this->getGerenciadorTable()->delete($id_gerenciador);

            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Gerenciador de ID $id_gerenciador deletado com sucesso");
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('gerenciadores', ['action' => 'main']);
    }

    /**
     * Metodo privado para obter instacia do Model GerenciadorTable
     *
     * @return GerenciadorTable
     */
    private function getGerenciadorTable()
    {
        // adicionar service ModelGerenciador a variavel de classe
        if (!$this->gerenciadorTable) {
            $this->gerenciadorTable = $this->getServiceLocator()->get('ModelGerenciador');
        }

        // return vairavel de classe com service ModelGerenciador
        return $this->gerenciadorTable;
    }

    // GET /gerenciadores/search?query=[nome]
    public function searchAction()
    {
        $nome = $this->params()->fromQuery('query', null);
        if (isset($nome)) {
            $result = $this->getGerenciadorTable()->search($nome);
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