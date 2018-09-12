<?php
namespace asbamboo\restfulApi;

use asbamboo\http\ResponseInterface;
use asbamboo\restfulApi\apiStore\ApiStoreInterface;
use asbamboo\di\ContainerInterface;
use asbamboo\http\ServerRequestInterface;
use asbamboo\restfulApi\exception\ApiException;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
class Controller implements ControllerInterface
{
    /**
     *
     * @var ApiStoreInterface
     * @var ContainerInterface
     * @var ServerRequestInterface $Request
     */
    private $ApiStore; private $Container; private $Request;

    /**
     *
     * @param ApiStoreInterface $ApiStore
     * @param ContainerInterface $Container
     * @param ServerRequestInterface $Request
     */
    public function __construct(ApiStoreInterface $ApiStore, ContainerInterface $Container, ServerRequestInterface $Request)
    {
        $this->ApiStore     = $ApiStore;
        $this->Container    = $Container;
        $this->Request      = $Request;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\ControllerInterface::api()
     */
    public function api(string $version, string $path) : ResponseInterface
    {
        try
        {
            $result = ['code' => 0, 'message' => '', 'data' => []];
            $class  = $this->ApiStore->findApiClass($version, $path);
            $Api    = $this->Container->get($class);
            $method = $this->Request->getMethod();
            if(class_exists($Api, $method)){
                $result['data'] = $Api->{$method}();
            }
        }catch(ApiException $e){
            $result['code']     = $e->getCode();
            $result['message']  = $e->getMessage();
        }finally{
            return $this->ApiStore->makeResponse($result);
        }
    }

    /**
     *
     * @param string $version
     * @param string $path
     * @return ResponseInterface
     */
    public function doc(string $version, string $path = null): ResponseInterface
    {

    }
}