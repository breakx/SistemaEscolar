<?php

namespace Main\Controller;

use Main\Form\MainForm;
use Main\Model\Main;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MainController extends AbstractActionController
{
    protected $mainTable;

    public function indexAction()
    {
        return new ViewModel();
    }

    public function cadastrarAction()
    {
        return ['formEstudante' => new MainForm()];
    }

    // POST /main/adicionar
    public function adicionarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new MainForm();
            // instancia model contato com regras de filtros e validações
            $modelMain = new Main();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity contato
            $form->setInputFilter($modelMain->getInputFilter());
            // passa para o objeto formulário os dados vindos da submissão
            $form->setData($request->getPost());

            var_dump($modelMain);

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - popular model com valores do formulário
                $modelMain->exchangeArray($form->getData());
                // 2 - persistir dados do model para banco de dados

                $this->getMainTable()->save($modelMain);

                // adicionar mensagem de sucesso
                $this->flashMessenger()
                    ->addSuccessMessage("Estudante criado com sucesso!");

                // redirecionar para action index no controller contatos
                return $this->redirect()->toRoute('main');
            } else { // em caso da validação não seguir o que foi definido

                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formEstudante', $form)
                    ->setTemplate('main/main/cadastrar');
            }
        }
    }

    /**
     * @return array
     */
    public function novapessoaAction()
    {
        $mainTable='dados_pessoais';
        return ['formDadosPessoais' => new MainForm($mainTable)];
    }

    // POST /main/adicionar
    public function adicionarpessoaAction()
    {
        $mainTable='dados_pessoais';
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new MainForm($mainTable);
            // instancia model contato com regras de filtros e validações
            $modelMain = new Main();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity contato
            $form->setInputFilter($modelMain->getInputFilter($mainTable));
            // passa para o objeto formulário os dados vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - popular model com valores do formulário
                $modelMain->exchangeArray($form->getData());
                // 2 - persistir dados do model para banco de dados
                $this->getMainTable($mainTable)->save($modelMain, $mainTable);

                // redirecionar para action index no controller dados pessoais
                return $this->redirect()->toRoute('main');
            } else { // em caso da validação não seguir o que foi definido

                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formDadosPessoais', $form)
                    ->setTemplate('main/main/novopessoa');
            }
        }
    }

    /**
     * @return array
     */
    public function novocursoAction()
    {
        $mainTable='cursos';
        return ['formCursos' => new MainForm($mainTable)];
    }

    // POST /main/adicionar
    public function adicionarcursoAction()
    {
        $mainTable='cursos';
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new MainForm($mainTable);
            // instancia model curso com regras de filtros e validações
            $modelMain = new Main();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity contato
            $form->setInputFilter($modelMain->getInputFilter($mainTable));
            // passa para o objeto formulário os dados vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - popular model com valores do formulário
                $modelMain->exchangeArray($form->getData());
                // 2 - persistir dados do model para banco de dados
                $this->getMainTable($mainTable)->save($modelMain, $mainTable);

                // redirecionar para action index no controller curso
                return $this->redirect()->toRoute('main');
            } else { // em caso da validação não seguir o que foi definido

                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formCursos', $form)
                    ->setTemplate('main/main/novocurso');
            }
        }
    }

    /**
     * @return array
     */
    public function novaserieAction()
    {
        $mainTable='series';
        return ['formSeries' => new MainForm($mainTable)];
    }

    public function adicionarserieAction()
    {
        $mainTable='series';
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new MainForm($mainTable);
            // instancia model curso com regras de filtros e validações
            $modelMain = new Main();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity serie
            $form->setInputFilter($modelMain->getInputFilter($mainTable));
            // passa para o objeto formulário os dados vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - popular model com valores do formulário
                $modelMain->exchangeArray($form->getData());
                // 2 - persistir dados do model para banco de dados
                $this->getMainTable($mainTable)->save($modelMain, $mainTable);

                // redirecionar para action index no controller curso
                return $this->redirect()->toRoute('main');
            } else { // em caso da validação não seguir o que foi definido

                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formSeries', $form)
                    ->setTemplate('main/main/novoserie');
            }
        }
    }

    /**
     * @return array
     */
    public function novamateriaAction()
    {
        $mainTable='materias';
        return ['formMaterias' => new MainForm($mainTable)];
    }

    public function adicionarmateriaAction()
    {
        $mainTable='materias';
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new MainForm($mainTable);
            // instancia model curso com regras de filtros e validações
            $modelMain = new Main();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity materia
            $form->setInputFilter($modelMain->getInputFilter($mainTable));
            // passa para o objeto formulário os dados vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - popular model com valores do formulário
                $modelMain->exchangeArray($form->getData());
                // 2 - persistir dados do model para banco de dados
                $this->getMainTable($mainTable)->save($modelMain, $mainTable);

                // redirecionar para action index no controller materia
                return $this->redirect()->toRoute('main');
            } else { // em caso da validação não seguir o que foi definido

                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formMaterias', $form)
                    ->setTemplate('main/main/novomateria');
            }
        }
    }

    /**
     * @return array
     */
    public function novousuarioAction()
    {
        $mainTable='usuarios';
        return ['formUsuarios' => new MainForm($mainTable)];
    }

    public function adicionarusuarioAction()
    {
        $mainTable='usuarios';
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new MainForm($mainTable);
            // instancia model curso com regras de filtros e validações
            $modelMain = new Main();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity usuario
            $form->setInputFilter($modelMain->getInputFilter($mainTable));
            // passa para o objeto formulário os dados vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - popular model com valores do formulário
                $modelMain->exchangeArray($form->getData());
                // 2 - persistir dados do model para banco de dados
                $this->getMainTable($mainTable)->save($modelMain, $mainTable);

                // redirecionar para action index no controller usuario
                return $this->redirect()->toRoute('main');
            } else { // em caso da validação não seguir o que foi definido

                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formUsuarios', $form)
                    ->setTemplate('main/main/novousuario');
            }
        }
    }

    /**
     * @return array
     */
    public function novofuncionarioAction()
    {
        $mainTable='funcionarios';
        return ['formFuncionarios' => new MainForm($mainTable)];
    }

    public function adicionarfuncionarioAction()
    {
        $mainTable='funcionarios';
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new MainForm($mainTable);
            // instancia model curso com regras de filtros e validações
            $modelMain = new Main();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity usuario
            $form->setInputFilter($modelMain->getInputFilter($mainTable));
            // passa para o objeto formulário os dados vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - popular model com valores do formulário
                $modelMain->exchangeArray($form->getData());
                // 2 - persistir dados do model para banco de dados
                $this->getMainTable($mainTable)->save($modelMain, $mainTable);

                // redirecionar para action index no controller aluno
                return $this->redirect()->toRoute('main');
            } else { // em caso da validação não seguir o que foi definido

                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formFuncionarios', $form)
                    ->setTemplate('main/main/novofuncionario');
            }
        }
    }

    /**
     * @return array
     */
    public function novoalunoAction()
    {
        $mainTable='alunos';
        return ['formAlunos' => new MainForm($mainTable)];
    }

    public function adicionaralunoAction()
    {
        $mainTable='alunos';
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new MainForm($mainTable);
            // instancia model curso com regras de filtros e validações
            $modelMain = new Main();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity usuario
            $form->setInputFilter($modelMain->getInputFilter($mainTable));
            // passa para o objeto formulário os dados vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - popular model com valores do formulário
                $modelMain->exchangeArray($form->getData());
                // 2 - persistir dados do model para banco de dados
                $this->getMainTable($mainTable)->save($modelMain, $mainTable);

                // redirecionar para action index no controller aluno
                return $this->redirect()->toRoute('main');
            } else { // em caso da validação não seguir o que foi definido

                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formAlunos', $form)
                    ->setTemplate('main/main/novoaluno');
            }
        }
    }

    /**
     * @return array
     */
    public function novotipousuarioAction()
    {
        $mainTable='tipo_usuario';
        return ['formTipoUsuarios' => new MainForm($mainTable)];
    }

    public function adicionartipousuarioAction()
    {
        $mainTable='tipo_usuario';
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new MainForm($mainTable);
            // instancia model curso com regras de filtros e validações
            $modelMain = new Main();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity usuario
            $form->setInputFilter($modelMain->getInputFilter($mainTable));
            // passa para o objeto formulário os dados vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - popular model com valores do formulário
                $modelMain->exchangeArray($form->getData());
                // 2 - persistir dados do model para banco de dados
                $this->getMainTable($mainTable)->save($modelMain, $mainTable);

                // redirecionar para action index no controller aluno
                return $this->redirect()->toRoute('main');
            } else { // em caso da validação não seguir o que foi definido

                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formTipoUsuarios', $form)
                    ->setTemplate('main/main/novotipousuario');
            }
        }
    }

    /**
     * @param $tabela
     * @return array|object
     */
    private function getMainTable($tabela)
    {
        // adicionar service Model a variavel de classe
        if (!$this->mainTable) {
            switch($tabela){
                case 'dados_pessoais':
                    $this->mainTable = $this->getServiceLocator()->get('ModelDadosPessoais',$tabela);
                    break;
                case 'cursos':
                    $this->mainTable = $this->getServiceLocator()->get('ModelCursos',$tabela);
                    break;
                case 'series':
                    $this->mainTable = $this->getServiceLocator()->get('ModelSeries',$tabela);
                    break;
                case 'materias':
                    $this->mainTable = $this->getServiceLocator()->get('ModelMaterias',$tabela);
                    break;
                case 'usuarios':
                    $this->mainTable = $this->getServiceLocator()->get('ModelUsuarios',$tabela);
                    break;
                case 'alunos':
                    $this->mainTable = $this->getServiceLocator()->get('ModelAlunos',$tabela);
                    break;
            }
        }

        // return vairavel de classe com service Model
        return $this->mainTable;
    }

}

