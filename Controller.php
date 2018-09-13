<?php
namespace asbamboo\restfulApi;

use asbamboo\http\ResponseInterface;
use asbamboo\restfulApi\apiStore\ApiStoreInterface;
use asbamboo\di\ContainerInterface;
use asbamboo\http\ServerRequestInterface;
use asbamboo\restfulApi\exception\ApiException;
use asbamboo\restfulApi\document\DocumentInterface;
use asbamboo\di\ContainerAwareTrait;
use asbamboo\restfulApi\document\Document;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
class Controller implements ControllerInterface
{
    use ContainerAwareTrait;

    /**
     *
     * @var ApiStoreInterface
     * @var ServerRequestInterface $Request
     */
    private $ApiStore; private $Request;

    /**
     *
     * @param ApiStoreInterface $ApiStore
     * @param ContainerInterface $Container
     * @param ServerRequestInterface $Request
     */
    public function __construct(ApiStoreInterface $ApiStore, ServerRequestInterface $Request)
    {
        $this->ApiStore     = $ApiStore;
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
            $result = ['code' => 0, 'message' => 'success', 'data' => []];
            $class  = $this->ApiStore->findApiClass($version, $path);
            $Api    = $this->Container->get($class);
            $method = $this->Request->getMethod();
            if(method_exists($Api, $method)){
                $result['data'] = $Api->{$method}();
            }
        }catch(ApiException $e){
            $result['code']     = $e->getCode();
            $result['message']  = $e->getMessage();
        }finally{
            return $this->ApiStore->makeResponse($result['code'], $result['message'], $result['data']);
        }
    }

    /**
     *
     * @param string $path
     * @return ResponseInterface
     */
    public function doc(string $version = '', string $path = ''): ResponseInterface
    {
        /**
         *
         * @var DocumentInterface $Document
         */
        $Document       = $this->Container->get(DocumentInterface::class);
        $api_versions   = $this->ApiStore->findApiVersions();
        if(!in_array($version)){
            return $Document->versionList();
        }else if($path == ''){
            return $Document->apiList($version);
        }else{
            return $Document->apiDetail($version, $path);
        }
    }
}