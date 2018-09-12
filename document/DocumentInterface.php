<?php
namespace asbamboo\restfulApi\document;

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
     * 获取文档模板文件皮肤
     *
     * @return string
     */
    public function getLayout() : string;

    /**
     * 解析并生成路径为$path的文档
     *
     * @return string
     */
    public function parse(string $path = null): string;
}