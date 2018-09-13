<?php
namespace asbamboo\restfulApi\apiStore;

use asbamboo\http\ResponseInterface;
use asbamboo\restfulApi\exception\NotFoundApiException;
use asbamboo\restfulApi\exception\NotSupportedFormatException;
use asbamboo\http\JsonResponse;

/**
 * api 仓库管理器
 *  - 查找api接口请求执行的class
 *  - 格式化api接口响应结果
 *
 * api仓库管理方式
 *  - 指定api仓库所在的namespace和dir（dir应该就是namespace所在的dir）
 *  - 在指定好的仓库目录中添加各版本接口
 *  - 添加新版本时。新版本库中只需要放置有改动的接口即可（删除也要添加一个类，做相应的处理）
 *  - 版本号中符号点"."，用下划线"_"代替。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class ApiStore implements ApiStoreInterface
{
    /**
     * API仓库的根命名空间
     * 需要与变量$dir对应
     *
     * @var string
     */
    private $namespace;

    /**
     * API仓库的根mulu
     * 需要与变量$namespace对应
     *
     * @var string
     */
    private $dir;

    /**
     *
     * @var string
     */
    private $format;

    /**
     * 支持的response格式
     *
     * @var array
     */
    private $supported_formats  = [self::FORMAT_JSON];

    /**
     * 自定义生成response的方法
     *
     * @var callable|null
     */
    private $make_response_method = null;

    /**
     *
     * @param string $namespace
     * @param string $dir
     * @param string $format
     */
    public function __construct(string $namespace, string $dir, string $format = self::FORMAT_JSON)
    {
        $this->namespace    = $namespace;
        $this->dir          = $dir;
        $this->setFormat($format);
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\apiStore\ApiStoreInterface::getNamespace()
     */
    public function getNamespace() : string
    {
        return $this->namespace;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\apiStore\ApiStoreInterface::getDir()
     */
    public function getDir() : string
    {
        return $this->dir;
    }

    /**
     * 目前仅支持json格式
     *  - 如果同时使用customMakeResponseMethod，并且开放更多支持的格式的话，customMakeResponseMethod应该被先调用
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\apiStore\ApiStoreInterface::setFormat()
     */
    public function setFormat(string $format = self::FORMAT_JSON) : ApiStoreInterface
    {
        if(!in_array($format, $this->supported_formats)){
            throw new NotSupportedFormatException('不支持的响应格式');
        }
        $this->format       = $format;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\apiStore\ApiStoreInterface::getFormat()
     */
    public function getFormat() : string
    {
        return $this->format;
    }

    /**
     * 自定义生成response的方法
     *  - 如果同时使用setFormat，并且开放更多支持的格式的话，customMakeResponseMethod应该被先调用
     *
     * @param callable $callback
     * @return ApiStoreInterface
     */
    public function customMakeResponseMethod(callable $callback, array $supported_formats = [self::FORMAT_JSON]) : ApiStoreInterface
    {
        $this->supported_formats        = $supported_formats;
        $this->make_response_method     = $callback;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\apiStore\ApiStoreInterface::findApiVersions()
     */
    public function findApiVersions() : array
    {
        return str_replace('_', '.', array_diff(scandir($this->getDir(), 1), ['.', '..']));
    }

    /**
     * 查找api接口对应执行的class
     *  - 首先在api仓库中查找有没有当前版本的api接口
     *  - 当传入的版本好不存在这个api接口时，查找上个版本库中有没有该接口
     *  - 编写新的api版本时，不需要将所有的接口都复制。仅需要把修改，或者新增加，或者删除的接口放在新的版本目录中
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\apiStore\ApiStoreInterface::findApiClass()
     */
    public function findApiClass(string $version, string $path) : string
    {
        $version        = str_replace('.', '_', $version);
        $namespace      = rtrim( $this->getNamespace(), '\\' );
        $parse_paths    = explode('/', rtrim($path, '/'));
        foreach($parse_paths AS $key => $parse_path){
            $parse_paths[$key]  = implode('', array_map('ucfirst', explode('-', strtolower($parse_path))));
        }

        $path   = implode('\\', $parse_paths);
        $class  =  $namespace . '\\' . $version . $path;
        if(!class_exists($class)){
            $versions   = str_replace('_', '.', $this->findApiVersions());
            foreach($versions AS $test_version){
                $class  = $namespace . '\\' . $test_version . $path;
                if(class_exists($class) && $test_version < $version){
                    goto CLASS_MATCHED;
                }
            }
            throw new NotFoundApiException('API接口不存在。');
        }
        CLASS_MATCHED:
        return $class;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\apiStore\ApiStoreInterface::makeResponse()
     */
    public function makeResponse(int $code, string $message, /*array*/ $data) : ResponseInterface
    {
        if(is_callable($this->make_response_method)){
            return call_user_func($this->make_response_method, $this, $code, $message, $data);
        }
        if($this->format == self::FORMAT_JSON){
            return new JsonResponse([
                'code'      => $code,
                'message'   => $message,
                'data'      => $data,
            ]);
        }
    }
}