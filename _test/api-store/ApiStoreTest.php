<?php
namespace asbamboo\restfulApi\_test\apiStore;

use PHPUnit\Framework\TestCase;
use asbamboo\restfulApi\apiStore\ApiStore;
use asbamboo\restfulApi\exception\NotSupportedFormatException;
use asbamboo\http\JsonResponse;
use asbamboo\restfulApi\_test\fixtures\apiStore\v1_0_0\ApiDelete;
use asbamboo\restfulApi\_test\fixtures\apiStore\v1_0_0\ApiFixed;
use asbamboo\restfulApi\_test\fixtures\apiStore\v1_0_0\ApiUpdate;
use asbamboo\restfulApi\_test\fixtures\apiStore\v2_0_0\ApiNew;
use asbamboo\restfulApi\_test\fixtures\apiStore\v2_0_0\ApiDelete AS ApiDelete2;
use \asbamboo\restfulApi\_test\fixtures\apiStore\v2_0_0\ApiUpdate as ApiUpdate2;
use asbamboo\restfulApi\exception\NotFoundApiException;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class ApiStoreTest extends TestCase
{
    public $ApiStore;

    public function setUp()
    {
        $namespace      = 'asbamboo\\restfulApi\\_test\\fixtures\\apiStore\\';
        $dir            = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'api-store';
        $this->ApiStore = new ApiStore($namespace, $dir);
    }

    public function testSetFormatException()
    {
        $this->expectException(NotSupportedFormatException::class);
        $this->ApiStore->setFormat('none-support');
    }

    public function testSetFormatNormal()
    {
        $this->ApiStore->setFormat(ApiStore::FORMAT_JSON);
        $this->assertInstanceOf(ApiStore::class, $this->ApiStore);
        return $this->ApiStore;
    }

    /**
     * @depends testSetFormatNormal
     */
    public function testGetFormat(ApiStore $ApiStore)
    {
        $this->assertEquals(ApiStore::FORMAT_JSON, $ApiStore->getFormat());
    }

    public function testCustomMakeResponseMethod()
    {
        $this->ApiStore->customMakeResponseMethod(function(){
            return new JsonResponse(['custom' => true]);
        }, [ApiStore::FORMAT_JSON, 'html']);
        $this->ApiStore->setFormat('html');
        $this->assertEquals('html', $this->ApiStore->getFormat());
        $this->assertEquals(json_encode(['custom' => true]), $this->ApiStore->makeResponse(0, '', '')->getBody()->getContents());
    }

    public function testFindApiClass()
    {
        $this->assertEquals(ApiDelete::class, $this->ApiStore->findApiClass('v1.0.0', '/api-delete/'));
        $this->assertEquals(ApiFixed::class, $this->ApiStore->findApiClass('v1.0.0', '/Api-Fixed/'));
        $this->assertEquals(ApiUpdate::class, $this->ApiStore->findApiClass('v1.0.0', '/Api-Update/'));
        $this->assertEquals(ApiFixed::class, $this->ApiStore->findApiClass('v2.0.0', '/Api-Fixed'));
        $this->assertEquals(ApiNew::class, $this->ApiStore->findApiClass('v2.0.0', '/Api-New'));
        $this->assertEquals(ApiDelete2::class, $this->ApiStore->findApiClass('v2.0.0', '/Api-Delete'));
        $this->assertEquals(ApiUpdate2::class, $this->ApiStore->findApiClass('v2.0.0', '/Api-Update'));
    }

    public function testNotFindApiClass()
    {
        $this->expectException(NotFoundApiException::class);
        $this->ApiStore->findApiClass('v1.0.0', '/Api-New/');
    }

    public function testMakeResponse()
    {
        $this->assertEquals(
            json_encode(['code' => 1000, 'message' => 'message', 'data' => ['total'=>0]]),
            $this->ApiStore->makeResponse(1000, 'message', ['total'=>0])->getBody()->getContents()
        );
    }
}
