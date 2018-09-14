<?php
namespace asbamboo\restfulApi\document;

use asbamboo\http\ResponseInterface;
use asbamboo\restfulApi\apiStore\ApiStoreInterface;
use asbamboo\restfulApi\apiStore\ApiClassInterface;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class Document implements DocumentInterface
{
    /**
     *
     * @var ApiStoreInterface
     */
    private $ApiStore;

    /**
     * 文档模板文件皮肤的路径
     *
     * @var string
     */
    private $layout;

    /**
     *
     * @param ApiStoreInterface $ApiStore
     * @param string $layout
     */
    public function __construct(ApiStoreInterface $ApiStore, string $layout = null)
    {
        $this->ApiStore = $ApiStore;
        $this->layout   = $layout ?? __DIR__ . DIRECTORY_SEPARATOR . 'layout';
    }

    /**
     * $ApiStore
     *
     * @return ApiStoreInterface
     */
    public function getApiStore() : ApiStoreInterface
    {
        return $this->ApiStore;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\DocumentInterface::versionListArray()
     */
    public function versionListArray()
    {
        return $this->getApiStore()->findApiVersions(1);
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
        $api_lists      = [];
        $dir            = $this->getApiStore()->getDir();
        $api_versions   = $this->getApiStore()->findApiVersions(1);
        foreach($api_versions AS $api_version){
            if($api_version <= $version){
                $version_dir    = rtrim($dir, DIRECTORY_SEPARATOR). DIRECTORY_SEPARATOR . str_replace('.', '_', $api_version);
//                 $version_dir;
            }
        }
    }

    private function readApiListInfo(string $version_dir) : array
    {
        $api_lists      = [];
        $names          = array_diff(scandir($version_dir), ['.', '..']);

        foreach($names AS $name){
            $path   = rtrim($version_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $name;
            if(is_dir( $path )){
                $api_lists  = array_merge($api_lists, $this->readApiListInfo($path));
                continue;
            }
            if(is_file($path)){
                $path   = substr($path, 0 , '-4'/*.php*/); //截掉文件后缀名".php"
            }
            if(class_exists($path) && $path instanceof ApiClassInterface){
                $api_info           = [];
                $apiReflectionClass = new \ReflectionClass($path);
                $apiReflectionClass->getDocComment();

                /*
                 * $apiReflectionClass 用注释指定数据结构的文件路径
                 * 数据结构的文件路径 用注释表示数据字段的各种说明，
                 *  - @result [post,put]表示那种接口状态下返回在结果里面
                 *  - @method [post,put]表示接受哪些请求方式
                 *  - @var 类型
                 *  - @required 是否必须
                 *  - @range 取值范围
                 *  - @desc 描述
                 */
                // 接口说明（包括接口名称）
                // 接口path
                // 数据结构说明
                // 接口的请求参数说明【post，delete，put等5个方式】
                // 接口返回结果说明【post，delete，put等5个方式】
            }
        }
        return $api_lists;
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