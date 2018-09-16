<?php
namespace asbamboo\restfulApi\apiStore;

/**
 * api接口处理类接口。
 *  - api仓库中所有的api类都应该实现这个接口
 *  - 注释 "@delete" 表示这个接口已经废弃
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
interface ApiClassInterface
{
    /**
     * HTTP GET
     * 返回资源列表
     *  - 注释"@close" 表示未开放这种http请求
     */
    public function get();

    /**
     * HTTP POST
     * 创建新的资源
     *  - 注释"@close" 表示未开放这种http请求
     */
    public function post();

    /**
     * HTTP PUT
     * 修改资源(传递完整的资源信息)
     *  - 注释"@close" 表示未开放这种http请求
     */
    public function put();

    /**
     * HTTP PATCH
     * 修改资源部分信息(传递部分的资源信息)
     *  - 注释"@close" 表示未开放这种http请求
     */
    public function patch();

    /**
     * HTTP DELETE
     * 删除资源
     *  - 注释"@close" 表示未开放这种http请求
     */
    public function delete();
}