<?php
namespace asbamboo\restfulApi\document;

/**
 * 处理api接口的实体类中的字段的帮助信息
 *  - 处理api接口的实体类 [asbamboo\restfulApi\document\ApiClassDocInterface::getEntityClass()]
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月15日
 */
interface ApiEntityPropertyDocInterface
{
    /**
     * 字段名
     *
     * @return string
     */
    public function getName() : string;

    /**
     * 字段的默认值
     *
     * @return string
     */
    public function getDefaultValue() : string;

    /**
     * 数据类型
     *  - "@var"
     *
     * @return string
     */
    public function getVar() : string;

    /**
     * 是否必须
     *  - "@required"
     *
     * @return string
     */
    public function getRequired() : string;

    /**
     * 取值范围
     *  - "@range"
     *
     * @return string
     */
    public function getRange() : string;

    /**
     * 描述
     *  - "@desc"
     *
     * @return string
     */
    public function getDesc() : string;

    /**
     * 这个字段接受的请求方式
     *  - @method
     *  - [post, get, put, delete, patch]
     *  - 空，表示这个字段不是http请求传入的参数
     *
     * @return array
     */
    public function getMethod() : array;

    /**
     * 这个字段在哪些请求方式下会作为结果返回
     *  - @result
     *  - [post, get, put, delete, patch]
     *  - 空，表示这个字段不会当做结果数据返回
     *
     * @return array
     */
    public function getResult() : array;
}