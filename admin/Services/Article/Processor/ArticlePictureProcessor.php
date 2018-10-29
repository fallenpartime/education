<?php
/**
 * 文章图片
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Article\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\Article\ArticlePicture;

class ArticlePictureProcessor extends BaseProcessor
{
    protected $tableName = 'article_pictures';
    protected $tableClass = ArticlePicture::class;
}