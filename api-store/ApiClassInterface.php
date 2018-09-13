<?php
namespace asbamboo\restfulApi\apiStore;

use asbamboo\di\ContainerInterface;

/**
 * api接口处理类接口。
 * api仓库中所有的api类都应该实现这个接口
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
interface ApiClassInterface
{
    /**
     * use asbamboo\di\ContainerAwareTrait;
     *
     * @param ContainerInterface $Container
     */
    public function setContainer(ContainerInterface $Container) : void;

    /**
     * HTTP GET
     * 不指定具体id时返回一个列表信息
     * 指定id时返回一个详情信息
     */
    public function get();

    /**
     * HTTP POST
     * 创建新的资源
     */
    public function post();

    /**
     * HTTP PUT
     * 修改资源(传递完整的资源信息)
     */
    public function put();

    /**
     * HTTP PATCH
     * 修改资源部分信息(传递部分的资源信息)
     */
    public function patch();

    /**
     * HTTP DELETE
     * 删除资源
     */
    public function delete();
}