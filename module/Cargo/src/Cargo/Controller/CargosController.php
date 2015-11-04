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
namespace Cargo\Controller;

// import ZendMvc
use Zend\Mvc\Controller\AbstractActionController;

// import ZendView
use Zend\View\Model\ViewModel;

// imort ModelCargoTable com alias
use Cargo\Model\CargoTable as ModelCargo;

// import CargoForm
use Cargo\Form\CargoForm;

// import ModelCargo
use Cargo\Model\Cargo;

class CargosController extends AbstractActionController
{
    protected $cargoTable;

    // GET /cargo
    public function indexAction()
    {
        return new ViewModel();
    }

    // GET /cargos
    public function mainAction()
    {
        // colocar parametros da url em um array
        $paramsUrl = [
            'pagina_atual'  => $this->params()->fromQuery('pagina', 1),
            'itens_pagina'  => $this->params()->fromQuery('itens_pagina', 10),
            'coluna_nome'   => $this->params()->fromQuery('coluna_nome', 'nome_cargo'),
            'coluna_sort'   => $this->params()->fromQuery('coluna_sort', 'ASC'),
            'search'        => $this->params()->fromQuery('search', null),
        ];

        // configuar método de paginação
        $paginacao = $this->getCargoTable()->fetchPaginator(
            /* $pagina */           $paramsUrl['pagina_atual'],
            /* $itensPagina */      $paramsUrl['itens_pagina'],
            /* $ordem */            "{$paramsUrl['coluna_nome']} {$paramsUrl['coluna_sort']}",
            /* $search */           $paramsUrl['search'],
            /* $itensPaginacao */   5
        );

        // retonar paginação mais os params de url para view
        return new ViewModel(['cargos' => $paginacao] + $paramsUrl);
    }

    // GET /cargos/novo
    public function novoAction()
    {
        return ['formCargos' => new CargoForm()];
    }

    // POST /cargos/adicionar
    public function adicionarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new CargoForm();
            // instancia model cargos com regras de filtros e validações
            $modelCargo = new Cargo();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity cargos
            $form->setInputFilter($modelCargo->getInputFilter());
            // passa para o objeto formulário os cargos vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os cargos à tabela no banco
                // 1 - popular model com valores do formulário
                $modelCargo->exchangeArray($form->getData());
                // 2 - persistir cargos do model para banco de cargos
                $this->getCargoTable()->save($modelCargo);

                // redirecionar para action index no controller cargos
                return $this->redirect()->toRoute('cargos', ['action' => 'main']);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formCargos', $form)
                    ->setTemplate('cargo/cargos/novo');
            }
        }
    }

    // GET /cargos/detalhes/id
    public function detalhesAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para cargos
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Cargo não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('cargos', ['action' => 'main']);
        }

        try {
            // aqui vai a lógica para pegar os cargos referente ao cargos
            // 1 - solicitar serviço para pegar o model responsável pelo find
            // 2 - solicitar form com cargos desse cargos encontrado
            // formulário com cargos preenchidos

            // lógica cache objeto cargos
            $nome_cache_cargo_id = "nome_cache_cargo_{$id}";
            if (!$this->cache()->hasItem($nome_cache_cargo_id)) {
                $cargo = $this->getCargoTable()->find($id);

                $this->cache()->setItem($nome_cache_cargo_id, $cargo);
            } else {
                $cargo = $this->cache()->getItem($nome_cache_cargo_id);
            }
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('cargos', ['action' => 'main']);
        }

        // cargos eviados para detalhes.phtml
        return (new ViewModel())
            ->setTerminal($this->getRequest()->isXmlHttpRequest())
            ->setVariable('cargos', $cargo)
            ;
    }

    // GET /cargos/editar/id
    public function editarAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para cargos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Cargo não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('cargos', ['action' => 'main']);
        }

        try {
            // variável com objeto cargos localizado
            $cargo = (array) $this->getCargoTable()->find($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('cargos', ['action' => 'main']);
        }

        // objeto form cargos vazio
        $form = new CargoForm();
        // popula objeto form cargos com objeto model cargos
        $form->setData($cargo);

        // cargos eviados para editar.phtml
        return ['formCargos' => $form];
    }

    // POST /cargos/editar/id
    public function atualizarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new CargoForm();
            // instancia model cargos com regras de filtros e validações
            $modelCargo = new Cargo();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity cargos
            $form->setInputFilter($modelCargo->getInputFilter());
            // passa para o objeto formulário os cargos vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para atualizar os cargos à tabela no banco
                // 1 - popular model com valores do formulário
                $modelCargo->exchangeArray($form->getData());
                // 2 - atualizar cargos do model para banco de cargos
                $this->getCargoTable()->update($modelCargo);

                // adicionar mensagem de sucesso
                $this->flashMessenger()
                    ->addSuccessMessage("Cargo editado com sucesso");

                $nome_cache_cargo_id = "nome_cache_cargo_{$modelCargo->id_cargo}";
                if ($this->cache()->hasItem($nome_cache_cargo_id)) {
                    $this->cache()->removeItem($nome_cache_cargo_id);
                }

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('cargos', ["action" => "main", "id" => $modelCargo->id_cargo]);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action editar com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formCargos', $form)
                    ->setTemplate('cargo/cargos/editar');
            }
        }
    }

    // DELETE /cargos/deletar/id
    public function deletarAction()
    {
        // filtra id_cargo passsado pela url
        $id_cargo = (int) $this->params()->fromRoute('id', 0);

        // se id_cargo = 0 ou não informado redirecione para cargos
        if (!$id_cargo) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Cargo não encotrado" .$id_cargo);
        } else {
            // aqui vai a lógica para deletar o cargos no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta cargos
            $this->getCargoTable()->delete($id_cargo);

            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Cargo de ID $id_cargo deletado com sucesso");
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('cargos', ['action' => 'main']);
    }

    /**
     * Metodo privado para obter instacia do Model CargoTable
     *
     * @return CargoTable
     */
    private function getCargoTable()
    {
        // adicionar service ModelCargo a variavel de classe
        if (!$this->cargoTable) {
            $this->cargoTable = $this->getServiceLocator()->get('ModelCargo');
        }

        // return vairavel de classe com service ModelCargo
        return $this->cargoTable;
    }

    // GET /cargos/search?query=[nome]
    public function searchAction()
    {
        $nome = $this->params()->fromQuery('query', null);
        if (isset($nome)) {
            $result = $this->getCargoTable()->search($nome);
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