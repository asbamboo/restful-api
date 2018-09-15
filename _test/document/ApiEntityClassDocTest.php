<?php
namespace asbamboo\restfulApi\_test\document;

use PHPUnit\Framework\TestCase;
use asbamboo\restfulApi\document\ApiEntityClassDoc;
use asbamboo\restfulApi\_test\fixtures\apiEntity\ApiFixed;
use asbamboo\restfulApi\document\ApiEntityPropertyDocInterface;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月15日
 */
class ApiEntityClassDocTest extends TestCase
{
    public function getApiEntity()
    {
        yield [ApiFixed::class];
        yield [new ApiFixed()];
    }

    /**
     * @dataProvider getApiEntity
     */
    public function testGetEntityPropertyDocs($api_entity)
    {
        $ApiEntityClassDoc  = new ApiEntityClassDoc($api_entity);
        $this->assertCount(2, $ApiEntityClassDoc->getEntityPropertyDocs());
        foreach($ApiEntityClassDoc->getEntityPropertyDocs() AS $doc){
            $this->assertInstanceOf(ApiEntityPropertyDocInterface::class, $doc);
        }
    }
}