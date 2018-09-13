<?php
namespace asbamboo\restfulApi\document;

use asbamboo\http\ResponseInterface;
use asbamboo\di\ContainerAwareTrait;
use asbamboo\restfulApi\apiStore\ApiStoreInterface;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class Document implements DocumentInterface
{
    use ContainerAwareTrait;

    /**
     * 文档模板文件皮肤的路径
     *
     * @var string
     */
    private $layout;

    /**
     *
     * @param string $layout
     */
    public function __construct(string $layout = null)
    {
        $this->layout   = $layout ?? __DIR__ . DIRECTORY_SEPARATOR . 'layout';
    }

    /**
     * $ApiStore
     *
     * @return ApiStoreInterface
     */
    private function getApiStore() : ApiStoreInterface
    {
        return $this->Container->get(ApiStoreInterface::class);
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\DocumentInterface::versionListArray()
     */
    public function versionListArray()
    {
//         return $this->getApiStore()->findApiVersions();
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\DocumentInterface::versionList()
     */
    public function versionListResponse() : ResponseInterface
    {

    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\DocumentInterface::apiListArray()
     */
    public function apiListArray(string $version) : Array
    {
        $dir    = $this->getApiStore()->getDir();

    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\DocumentInterface::apiList()
     */
    public function apiListResponse(string $version) : ResponseInterface
    {

    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\DocumentInterface::apiDetailArray()
     */
    public function apiDetailArray(string $version, string $path) : Array
    {
//         $dir    = $this->getApiStore()->getDir();

    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\DocumentInterface::apiDetail()
     */
    public function apiDetailResponse(string $version, string $path) : ResponseInterface
    {

    }
}