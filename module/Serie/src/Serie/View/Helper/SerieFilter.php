<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 30/09/2015
 * Time: 11:35
 */

namespace Serie\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Serie\Model\Serie;

class SerieFilter extends AbstractHelper
{

    protected $serie;

    public function __invoke(Serie $serie)
    {
        $this->serie = $serie;

        return $this;
    }

    public function idSerie()
    {
        $result = $this->serie->id_serie;

        return $this->view->escapeHtml($result);
    }

    public function nomeSerie()
    {
        $result = $this->serie->nome_serie;

        return $this->view->escapeHtml($result);
    }

    public function subTipo()
    {
        $result = $this->serie->subtipo;

        return $this->view->escapeHtml($result);
    }

}