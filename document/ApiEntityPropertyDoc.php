<?php
namespace asbamboo\restfulApi\document;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月15日
 */
class ApiEntityPropertyDoc implements ApiEntityPropertyDocInterface
{
    /**
     *
     * @var array
     */
    private $docs;

    /**
     *
     * @var \ReflectionProperty
     */
    private $property;

    /**
     *
     * @param \ReflectionProperty|array[class=>property] $property
     */
    public function __construct(/*ReflectionProperty|array*/ $property)
    {
        if(is_array($property)){
            @list($class, $name) = $property;
            $property   = new \ReflectionProperty($class, $name);
        }
        $this->parseDoc($property);
        $this->property = $property;
    }

    /**
     * 解析注释
     *
     * @param \ReflectionProperty $property
     */
    private function parseDoc(\ReflectionProperty $property)
    {
        $document   = $property->getDocComment();

        if(preg_match_all('#@(\w+)\s(.*)[\r\n]#siU', $document, $matches)){
            foreach($matches[1] AS $index => $key){
                $this->docs[$key][]   = trim($matches[2][$index]);
            }
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\ApiEntityPropertyDocInterface::getName()
     */
    public function getName() : string
    {
        return $this->property->getName();
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\ApiEntityPropertyDocInterface::getDefaultValue()
     */
    public function getDefaultValue() : string
    {
        return isset($this->docs['default']) ? implode('\r\n', $this->docs['default']) : '';
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\ApiEntityPropertyDocInterface::getVar()
     */
    public function getVar(): string
    {
        return isset($this->docs['var']) ? implode('\r\n', $this->docs['var']) : '';
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\ApiEntityPropertyDocInterface::getRange()
     */
    public function getRange(): string
    {
        return isset($this->docs['range']) ? implode('\r\n', $this->docs['range']) : '';
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\ApiEntityPropertyDocInterface::getRequired()
     */
    public function getRequired(): string
    {
        return isset($this->docs['required']) ? implode('\r\n', $this->docs['required']) : '';
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\ApiEntityPropertyDocInterface::getDesc()
     */
    public function getDesc(): string
    {
        return isset($this->docs['desc']) ? implode('\r\n', $this->docs['desc']) : '';
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\ApiEntityPropertyDocInterface::getResult()
     */
    public function getResult(): array
    {
        if(isset($this->docs['result'])){
            $this->docs['result']   = trim(strtoupper(implode(' ', $this->docs['result'])));
            $this->docs['result']   = preg_split('@\s+@', $this->docs['result']);
            return $this->docs['result'];
        }
        return [];
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\ApiEntityPropertyDocInterface::getMethod()
     */
    public function getMethod(): array
    {
        if(isset($this->docs['method'])){
            $this->docs['method']   = trim(strtoupper(implode(' ', $this->docs['method'])));
            $this->docs['method']   = preg_split('@\s+@', $this->docs['method']);
            return $this->docs['method'];
        }
        return [];
    }
}