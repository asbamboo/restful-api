<?php
namespace asbamboo\restfulApi;

use asbamboo\http\ResponseInterface;

/**
 * 控制器
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
interface ControllerInterface
{
    /**
     * 查看api文档
     *  - 通过解析api类相关的注释生成api文档
     *  - 当$path 等于 null 的时候返回api的列表
     *
     * @param string $version   api 版本
     * @param string $path  api uil
     * @return ResponseInterface
     */
    public function doc(string $version = '', string $path = ''): ResponseInterface;

    /**
     * http请求一个api接口, 获取一个响应信息
     *
     * @param string $version
     * @param string $path
     * @return ResponseInterface
     */
    public function api(string $version, string $path) : ResponseInterface;
}