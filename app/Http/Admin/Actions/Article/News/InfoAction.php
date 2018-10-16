<?php
/**
 * 教育新闻详情
 * Date: 2018/10/8
 * Time: 22:43
 */
namespace App\Http\Admin\Actions\Article\News;

use Admin\Actions\BaseAction;
use Admin\Models\Article;
use Admin\Services\Article\Processor\ArticlePictureProcessor;
use Admin\Services\Article\Processor\ArticleProcessor;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class InfoAction extends BaseAction
{
    use ApiActionTrait;

    protected $_article = null;
    protected $_type = 1;
    protected $pictureProcessor = null;

    protected function getPictureProcessor()
    {
        if (empty($this->pictureProcessor)) {
            $this->pictureProcessor = new ArticlePictureProcessor();
        }
        return $this->pictureProcessor;
    }

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $workNo = $httpTool->getBothSafeParam('work_no', HttpConfig::PARAM_NUMBER_TYPE);
        $this->_type = $httpTool->getBothSafeParam('type', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_article = Article::find($id);
        }
        if ($workNo == 1 || $workNo == 2) {
            if ($workNo == 1) {
                return $this->showInfo();
            } else {
                $this->process();
            }
        }
        $this->errorJson(500, '请求类型不匹配');
    }

    protected function showInfo()
    {
        $result = [
            'record'            =>  $this->_article,
            'articleType'       =>  1,
            'menu'              =>  ['articleCenter', 'newsManage', 'articleNewsInfo'],
            'actionUrl'         => route('articleNewsInfo', ['work_no'=>2, 'type'=>$this->_type]),
        ];
        return $this->createView('admin.article.news.info', $result);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $title = $httpTool->getBothSafeParam('title');
        $description = $httpTool->getBothSafeParam('description');
        $content = $httpTool->getBothSafeParam('content');
        $publishedAt = $httpTool->getBothSafeParam('pubdate');
        $picPreview = $this->request->get('list_pic_preview');
        $title = trim($title);
        $description = trim($description);
        $publishedAt = trim($publishedAt);
        if(empty($title)){
            $this->errorJson(500, '标题不能为空');
        }
        if(empty($description)){
            $this->errorJson(500, '描述不能为空');
        }
        if(empty($content)){
            $this->errorJson(500, '内容不能为空');
        }
        if (!empty($id) && empty($this->_article)) {
            $this->errorJson(500, '文章不存在');
        }
        $data = [
            'type'      =>  $this->_type,
            'title'     =>  $title,
            'description'   =>  $description,
            'content'   =>  $content,
            'published_at'  =>  !empty($publishedAt)? $publishedAt: null,
            'list_pic'      =>  !empty($picPreview)?  $picPreview[0]: null,
        ];
        $res = empty($this->_article)? $this->save($data): $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function clearImage($articleId)
    {
        if ($articleId > 0) {
            $this->getPictureProcessor()->remove(['article_id'=>$articleId, 'type'=>1]);
        }
    }

    protected function processImage($imageUrl, $articleId, $create = 0)
    {
        $imageUrl = trim($imageUrl);
        if ($articleId <= 0) {
            return false;
        }
        if (!empty($imageUrl)) {
            $data = [
                'article_id'    =>  $articleId,
                'type'          =>  1,
                'pic'           =>  $imageUrl,
            ];
        }
        if ($create == 1) {
            $this->clearImage($articleId);
            if (!empty($data)) {
                list($status, $picture) = $this->getPictureProcessor()->insert($data);
                return $status;
            }
        } else {
            if (empty($imageUrl)) {
                $this->clearImage($articleId);
            } else if($imageUrl != $this->_article['pic']) {
                $this->clearImage($articleId);
                if (!empty($data)) {
                    list($status, $picture) = $this->getPictureProcessor()->insert($data);
                    return $status;
                }
            }
        }
        return false;
    }

    protected function save($data)
    {
        $processor = new ArticleProcessor();
        list($status, $article) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '文章创建失败');
        }
        $this->processImage($data['list_pic'], $article->id, 1);
        $this->successJson();
    }

    protected function update($data)
    {
        if ($this->_article['type'] != 1) {
            $this->errorJson(500, '文章类别非新闻类型');
        }
        $processor = new ArticleProcessor();
        list($status, $id) = $processor->update($this->_article->id, $data);
        if (empty($status)) {
            $this->errorJson(500, '文章修改失败');
        }
        $this->processImage($data['list_pic'], $id);
        $this->successJson();
    }
}
