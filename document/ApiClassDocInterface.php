<?php
namespace asbamboo\restfulApi\document;

/**
 * 实现"asbamboo\restfulApi\apiStore\ApiClassInterface"的类的帮助信息。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月15日
 */
interface ApiClassDocInterface
{
    /**
     * API名称
     * 应该解析ApiClass的注释中的 "@name" 信息
     *
     * @return string
     * @throws
     */
    public function getName() : string;

    /**
     * api 访问 path
     *
     * @return string
     */
    public function getPath() : string;

    /**
     * 如果注释里面解析到 "@delete"
     *  - 表示接口在这个版本删除。
     *
     * @return bool
     */
    public function isDelete() : bool;

    /**
     * 反应数据结构的实体类
     * 应该解析ApiClass的注释中的 "@entity" 信息
     *  - 该类的注释行也是一个帮助文档信息
     *  - 该类的每个注释行需要反应"哪些http请求允许接收这个参数,哪些http请求返回这个参数"。
     *
     * @return string
     */
    public function getEntityClass() : string;

    /**
     * 获取反应数据结构的实体类的帮助信息
     *  - 根据getEntityClass得到的类，获取该类的帮助信息
     *  - 如果接口没有实体类的话返回null
     *
     * @return ApiEntityClassDocInterface|NULL
     */
    public function getApiEntityClassDoc() : ?ApiEntityClassDocInterface;
}