<?php
namespace asbamboo\restfulApi\_test\document;

use PHPUnit\Framework\TestCase;
use asbamboo\restfulApi\document\ApiClassDoc;
use asbamboo\restfulApi\_test\fixtures\apiStore\v1_0_0\ApiFixed;
use asbamboo\restfulApi\_test\fixtures\apiStore\v1_0_0\ApiUpdate;
use \asbamboo\restfulApi\_test\fixtures\apiEntity\ApiUpdate AS ApiUpdateEntity;
use asbamboo\restfulApi\document\ApiEntityClassDocInterface;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class ApiClassDocTest extends TestCase
{
    public function testGetName()
    {
        $ApiClassDoc    = new ApiClassDoc(ApiFixed::class, 'asbamboo\\restfulApi\\_test\\fixtures\\apiStore');
        $this->assertEquals('', $ApiClassDoc->getName());

        $ApiClassDoc    = new ApiClassDoc(ApiUpdate::class, 'asbamboo\\restfulApi\\_test\\fixtures\\apiStore');
        $this->assertEquals('测试在2.0版本会修改的接口', $ApiClassDoc->getName());
    }

    public function testGetPath()
    {
        $ApiClassDoc    = new ApiClassDoc(ApiFixed::class, 'asbamboo\\restfulApi\\_test\\fixtures\\apiStore');
        $this->assertEquals('/api-fixed', $ApiClassDoc->getPath());
    }

    public function testGetEntityClass()
    {
        $ApiClassDoc    = new ApiClassDoc(ApiFixed::class, 'asbamboo\\restfulApi\\_test\\fixtures\\apiStore');
        $this->assertEquals('', $ApiClassDoc->getEntityClass());

        $ApiClassDoc    = new ApiClassDoc(ApiUpdate::class, 'asbamboo\\restfulApi\\_test\\fixtures\\apiStore');
        $this->assertEquals(ApiUpdateEntity::class, $ApiClassDoc->getEntityClass());
    }

    public function testGetApiEntityClassDoc()
    {
        $ApiClassDoc    = new ApiClassDoc(ApiFixed::class, 'asbamboo\\restfulApi\\_test\\fixtures\\apiStore');
        $this->assertEquals(null, $ApiClassDoc->getApiEntityClassDoc());

        $ApiClassDoc    = new ApiClassDoc(ApiUpdate::class, 'asbamboo\\restfulApi\\_test\\fixtures\\apiStore');
        $this->assertInstanceOf(ApiEntityClassDocInterface::class, $ApiClassDoc->getApiEntityClassDoc());
    }
}