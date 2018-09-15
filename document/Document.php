<?php
namespace asbamboo\restfulApi\document;

use asbamboo\http\ResponseInterface;
use asbamboo\restfulApi\apiStore\ApiStoreInterface;
use asbamboo\restfulApi\apiStore\ApiClassInterface;
use asbamboo\restfulApi\exception\NotFoundApiException;
use asbamboo\http\TextResponse;

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
        $this->layout   = $layout ?? __DIR__ . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'template.html';
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
    public function versionListArray() : array
    {
        return $this->getApiStore()->findApiVersions(1);
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
                $api_lists      = array_merge($this->readApiListInfo($version_dir), $api_lists);
            }
        }
        ksort($api_lists);
        return $api_lists;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\DocumentInterface::apiDetailInfo()
     */
    public function apiDetailInfo(string $version, string $path) : ApiClassDocInterface
    {
        $namespace      = rtrim($this->getApiStore()->getNamespace(), '\\');
        $api_versions   = $this->getApiStore()->findApiVersions(1);

        $parse_paths    = explode('/', rtrim($path, '/'));
        foreach($parse_paths AS $key => $parse_path){
            $parse_paths[$key]  = implode('', array_map('ucfirst', explode('-', strtolower($parse_path))));
        }
        $path           = implode('\\', $parse_paths);

        foreach($api_versions AS $api_version){
            if($api_version <= $version){
                $api_version    = str_replace('.', '_', $api_version);
                $class      = $namespace . '\\' .$api_version . $path;
                if(class_exists($class)){
                    $ApiClassDoc = new ApiClassDoc($class, $namespace);
                    return $ApiClassDoc;
                }
            }
        }
        throw new NotFoundApiException(sprintf('api 接口不存在，版本[%s], 资源[%s]', $version, $path));
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\document\DocumentInterface::apiDetail()
     */
    public function response(string $version='', string $path='') : ResponseInterface
    {
        $all_versions       = $this->versionListArray();
        $current_version    = $version == '' ? current($all_versions) : $version;
        $api_lists          = $this->apiListArray($current_version);
        $ApiClassDoc        = $path == '' ? null : $this->apiDetailInfo($version, $path);
        ob_start();
        include $this->layout;
        $html   = ob_get_contents();
        ob_end_clean();
        return new TextResponse($html);
    }

    /**
     * 读取Api列表的帮助信息
     *
     * @param string $version_dir
     * @return array
     */
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
            $class  = '';
            if(is_file($path)){
                $storedir_length    = strlen($this->getApiStore()->getDir());
                $ext_pos            = '-4'; //截掉文件后缀名".php"
                $class              = substr($path, $storedir_length, $ext_pos);
                $class              = str_replace(DIRECTORY_SEPARATOR, '\\', $class);
                $class              = rtrim($this->getApiStore()->getNamespace(), '\\') . $class;
            }

            if(class_exists($class) && in_array(ApiClassInterface::class, class_implements($class))){
                $ApiClassDoc                        = new ApiClassDoc($class, $this->getApiStore()->getNamespace());
                $api_lists[$ApiClassDoc->getPath()] = $ApiClassDoc;
            }
        }
        return $api_lists;
    }
}