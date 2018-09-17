<?php
namespace asbamboo\restfulApi\_test\document;

use PHPUnit\Framework\TestCase;
use asbamboo\restfulApi\apiStore\ApiStore;
use asbamboo\restfulApi\document\Document;
use asbamboo\restfulApi\exception\NotFoundApiException;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class DocumentTest extends TestCase
{
    public $ApiStore;

    public function setUp()
    {
        $namespace      = 'asbamboo\\restfulApi\\_test\\fixtures\\apiStore\\';
        $dir            = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'api-store';
        $this->ApiStore = new ApiStore($namespace, $dir);
    }

    public function testGetApiStore()
    {
        $Document   = new Document($this->ApiStore);
        $this->assertEquals($this->ApiStore, $Document->getApiStore());
    }

    public function testVersionListArray()
    {
        $Document   = new Document($this->ApiStore);
        $this->assertEquals(['v2.0.0', 'v1.0.0'], $Document->versionListArray());
    }

    public function testApiListArray()
    {
        $Document   = new Document($this->ApiStore);
        $api_lists  = $Document->apiListArray('v2.0.0');
        $apis       = array_keys($api_lists);
        $equals     = ['/api-delete', '/api-new', '/api-update', '/api-fixed'];
        sort($equals);
        sort($apis);
        $this->assertEquals($equals, $apis);

        $Document   = new Document($this->ApiStore);
        $api_lists  = $Document->apiListArray('v1.0.0');
        $apis       = array_keys($api_lists);
        $equals     = ['/api-delete', '/api-update', '/api-fixed'];
        sort($equals);
        sort($apis);
        $this->assertEquals($equals, $apis);
    }

    public function testApiDetailInfo()
    {
        $Document       = new Document($this->ApiStore);
        $ApiClassDoc    = $Document->apiDetailInfo('v2.0.0', '/api-delete');
        $this->assertTrue($ApiClassDoc->isDelete());

        $Document       = new Document($this->ApiStore);
        $ApiClassDoc    = $Document->apiDetailInfo('v1.0.0', '/api-delete');
        $this->assertFalse($ApiClassDoc->isDelete());

        $this->expectException(NotFoundApiException::class);
        $Document       = new Document($this->ApiStore);
        $ApiClassDoc    = $Document->apiDetailInfo('v1.0.0', '/api-new');
    }

    public function testResponse()
    {
        $Document       = new Document($this->ApiStore);
//         var_dump($Document->response('v2.0.0', '/api-update')->getBody()->getContents());
//         exit;
    }
}