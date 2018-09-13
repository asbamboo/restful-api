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
     *
     * @var string
     */
    const FORMAT_JSON   = 'json';

    /**
     * 获取api仓库的命名空间
     * 需要与getDir对应
     *
     * @return string
     */
    public function getNamespace() : string;

    /**
     * 获取api仓库的文件目录
     * 需要与变量getNamespace对应
     *
     * @return string
     */
    public function getDir() : string;

    /**
     * 设置elf::makeResponse方法使用那种格式
     *
     * @param string $format
     * @return string
     */
    public function setFormat(string $format = self::FORMAT_JSON) : ApiStoreInterface;

    /**
     * 获取self::makeResponse方法使用那种格式
     *
     * @return string
     */
    public function getFormat() : string;

    /**
     * 查找某个版本的api应该被使用class处理
     *
     * @param string $version
     * @param string $path
     * @return string
     */
    public function findApiClass(string $version, string $path) : string;

    /**
     * 放回所有的api版本列表
     *
     * @return array
     */
    public function findApiVersions() : array;

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