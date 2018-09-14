<?php
namespace asbamboo\restfulApi\apiStore;

use asbamboo\restfulApi\exception\NotFoundApiException;

/**
 * api接口抽象类
 *  - 继承本抽象类的api类，如果不重写相应的处理方法，将抛出NotFoundApiException。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
abstract class ApiClassAbstract implements ApiClassInterface
{
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\apiStore\ApiClassInterface::get()
     */
    public function get()
    {
        throw new NotFoundApiException('api接口不存在.');
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\apiStore\ApiClassInterface::post()
     */
    public function post()
    {
        throw new NotFoundApiException('api接口不存在.');
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\apiStore\ApiClassInterface::put()
     */
    public function put()
    {
        throw new NotFoundApiException('api接口不存在.');
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\apiStore\ApiClassInterface::patch()
     */
    public function patch()
    {
        throw new NotFoundApiException('api接口不存在.');
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\apiStore\ApiClassInterface::delete()
     */
    public function delete()
    {
        throw new NotFoundApiException('api接口不存在.');
    }
}
