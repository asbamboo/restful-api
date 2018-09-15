<?php
namespace asbamboo\restfulApi\document;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月15日
 */
class ApiEntityClassDoc implements ApiEntityClassDocInterface
{
    /**
     *
     * @var ApiEntityPropertyDocInterface[]
     */
    private $entity_property_docs;

    /**
     *
     * @param string|object $api_entity 表示数据结构的实体类的类名或者是实例
     */
    public function __construct($api_entity)
    {
        $this->parse($api_entity);
    }

    /**
     *
     * @param string|object $api_entity 表示数据结构的实体类的类名或者是实例
     */
    private function parse($api_entity)
    {
        $Reflection = new \ReflectionClass($api_entity);
        foreach($Reflection->getProperties() AS $Property){
            $this->entity_property_docs[] = new ApiEntityPropertyDoc($Property);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\ApiEntityClassDocInterface::getEntityPropertyDocs()
     */
    public function getEntityPropertyDocs(): array
    {
        return $this->entity_property_docs??[];
    }
}