<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\RedisManager;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */

    protected $fileCache;
    protected $redisCache;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {

        parent::initController($request, $response, $logger);
        $config = new \Config\Cache();
        //$this->redisCache = service('predis');
        $config->handler = 'predis';
        $this->redisCache = \Config\Services::cache($config, false);
        $this->fileCache = $this->handled();
    }
    public function handled(string $handler = 'file')
    {
        $config = new \Config\Cache();
        $config->handler = $handler;
        return \Config\Services::cache($config, false);
    }
}
