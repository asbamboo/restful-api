<?php
namespace asbamboo\restfulApi\_test\document;

use PHPUnit\Framework\TestCase;
use asbamboo\restfulApi\_test\fixtures\apiEntity\ApiFixed;
use asbamboo\restfulApi\document\ApiEntityPropertyDoc;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月15日
 */
class ApiEntityPropertyDocTest extends TestCase
{
    public function testGetName()
    {
        $property               = new \ReflectionProperty(ApiFixed::class, 'name');
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals('name', $ApiEntityPropertyDoc->getName());
        $property               = [ApiFixed::class, 'value'];
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals('value', $ApiEntityPropertyDoc->getName());
    }

    public function testGetDefaultValue()
    {
        $property               = new \ReflectionProperty(ApiFixed::class, 'name');
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals('', $ApiEntityPropertyDoc->getDefaultValue());
        $property               = [ApiFixed::class, 'value'];
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals('0', $ApiEntityPropertyDoc->getDefaultValue());
    }

    public function testGetVar()
    {
        $property               = new \ReflectionProperty(ApiFixed::class, 'name');
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals('', $ApiEntityPropertyDoc->getVar());
        $property               = [ApiFixed::class, 'value'];
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals('int', $ApiEntityPropertyDoc->getVar());
    }

    public function testGetRange()
    {
        $property               = new \ReflectionProperty(ApiFixed::class, 'name');
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals('', $ApiEntityPropertyDoc->getRange());
        $property               = [ApiFixed::class, 'value'];
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals('0-10', $ApiEntityPropertyDoc->getRange());
    }


    public function testGetRequired()
    {
        $property               = new \ReflectionProperty(ApiFixed::class, 'name');
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals('', $ApiEntityPropertyDoc->getRequired());
        $property               = [ApiFixed::class, 'value'];
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals('否', $ApiEntityPropertyDoc->getRequired());
    }

    public function testGetDesc()
    {
        $property               = new \ReflectionProperty(ApiFixed::class, 'name');
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals('', $ApiEntityPropertyDoc->getDesc());
        $property               = [ApiFixed::class, 'value'];
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals('说明', $ApiEntityPropertyDoc->getDesc());
    }


    public function testGetMethod()
    {
        $property               = new \ReflectionProperty(ApiFixed::class, 'name');
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals([], $ApiEntityPropertyDoc->getMethod());
        $property               = [ApiFixed::class, 'value'];
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals(['POST', 'GET', 'PUT'], $ApiEntityPropertyDoc->getMethod());
    }

    public function testGetResult()
    {
        $property               = new \ReflectionProperty(ApiFixed::class, 'name');
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals([], $ApiEntityPropertyDoc->getResult());
        $property               = [ApiFixed::class, 'value'];
        $ApiEntityPropertyDoc   = new ApiEntityPropertyDoc($property);
        $this->assertEquals(['POST', 'GET', 'PUT'], $ApiEntityPropertyDoc->getResult());
    }
}
