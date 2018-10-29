<?php
/**
 * 文章
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Article\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\Article\Article;

class ArticleProcessor extends BaseProcessor
{
    protected $tableName = 'articles';
    protected $tableClass = Article::class;
}