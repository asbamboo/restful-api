<?php
namespace asbamboo\restfulApi\document;

use asbamboo\http\ResponseInterface;
use asbamboo\restfulApi\apiStore\ApiStoreInterface;

/**
 * 文档生成器
 *  - 根据获取的api仓库中api类的注释信息解析生成文档。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
interface DocumentInterface
{
    /**
     * 获取Api版本库信息
     *
     * @return ApiStoreInterface
     */
    public function getApiStore() : ApiStoreInterface;

    /**
     * 版本列表数组
     *
     * @return array
     */
    public function versionListArray() : array;

    /**
     * 版本列表响应
     *
     * @return ResponseInterface
     */
    public function versionListResponse() : ResponseInterface;

    /**
     * API接口列表数组
     *
     * @param string $version
     * @return array
     */
    public function apiListArray(string $version) : array;

    /**
     * API接口列表响应
     *
     * @param string $version
     * @return ResponseInterface
     */
    public function apiListResponse(string $version) : ResponseInterface;

    /**
     * API接口详情数组
     *
     * @param string $version
     * @param string $path
     * @return array
     */
    public function apiDetailArray(string $version, string $path) : array;

    /**
     * API接口详情响应
     *
     * @param string $version
     * @param string $path
     * @return ResponseInterface
     */
    public function apiDetailResponse(string $version, string $path) : ResponseInterface;
}