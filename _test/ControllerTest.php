<?php
namespace asbamboo\restfulApi\_test;

use PHPUnit\Framework\TestCase;
use asbamboo\restfulApi\apiStore\ApiStore;
use asbamboo\http\ServerRequest;
use asbamboo\di\Container;
use asbamboo\di\ServiceMappingCollection;
use asbamboo\di\ServiceMapping;
use asbamboo\restfulApi\Controller;
use asbamboo\restfulApi\_test\fixtures\apiStore\v1_0_0\ApiFixed;
use function asbamboo\restfulApi\apiStore\testfun;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class ControlerTest extends TestCase
{
    public $Controller;

    public function setUp()
    {
        testfun();
        $namespace          = 'asbamboo\\restfulApi\\_test\\fixtures\\apiStore\\';
        $dir                = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'api-store';
        $ServiceMappings    = new ServiceMappingCollection();
        $ServiceMappings->add(new ServiceMapping(['id' =>'request','class' => ServerRequest::class]));
        $ServiceMappings->add(new ServiceMapping([
            'id'            =>'api_store',
            'class'         => ApiStore::class,
            'init_params'   => ['namespace' => $namespace, 'dir' => $dir],
        ]));
        $Container          = new Container($ServiceMappings);
        $this->Controller   = $Container->get(Controller::class);
    }

    public function testApi()
    {
        $TestApiFixed   = new ApiFixed();
        $response       = $this->Controller->api('v1.0.0', '/api-fixed');
        $this->assertEquals(
            json_encode(['code'=>0,'message'=>'success','data'=>$TestApiFixed->get()]),
            $response->getBody()->getContents()
        );
    }
}
