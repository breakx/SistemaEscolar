<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 30/09/2015
 * Time: 13:59
 */

namespace Cargo\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

use Zend\Cache\Storage\Adapter\Filesystem as CacheFilesystem;

class Cache extends AbstractPlugin
{

    public $cache;

    public function __construct(CacheFilesystem $cache)
    {
        if (!is_null($cache)) {
            $this->cache = $cache;
        }
    }

    public function __invoke()
    {
        return $this->cache;
    }

}