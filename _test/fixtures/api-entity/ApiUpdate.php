<?php
namespace asbamboo\restfulApi\_test\fixtures\apiEntity;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月15日
 */
class ApiUpdate
{
    private $name;

    /**
     * @default 0
     * @var int
     * @range 0-10
     * @required 否
     * @desc 说明
     * @method POST GET PUT
     * @result POST GET PUT
     */
    private $value;
}