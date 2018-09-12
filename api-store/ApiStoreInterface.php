<?php
namespace asbamboo\restfulApi\apiStore;

use asbamboo\http\ResponseInterface;

/**
 * api 仓库接口
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
interface ApiStoreInterface
{
    /**
     * 返回api仓库的命名空间
     *
     * @return string
     */
    public function namespace() : string;

    /**
     * 查找某个版本的api应该被使用class处理
     *
     * @param string $version
     * @param string $path
     * @return string
     */
    public function findApiClass(string $version, string $path) : string;

    /**
     * 生成Response信息
     *
     * @param int $code
     * @param string $message
     * @param array $data
     * @return ResponseInterface
     */
    public function makeResponse(int $code, string $message, array $data) : ResponseInterface;
}