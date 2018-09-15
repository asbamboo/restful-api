<?php
namespace asbamboo\restfulApi\document;

/**
 * 表示api接口数据结构的实体类的帮助信息
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月15日
 */
interface ApiEntityClassDocInterface
{
    /**
     * 返回api接口处理的实体类的所有字段的帮助信息
     *
     * @return ApiEntityPropertyDocInterface[]
     */
    public function getEntityPropertyDocs() : array;
}