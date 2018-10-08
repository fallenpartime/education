<?php
/**
 * 教育新闻详情
 * Date: 2018/10/8
 * Time: 22:43
 */
namespace App\Http\Admin\Actions\Article\News;

use Admin\Actions\BaseAction;
use Admin\Models\Article;
use Admin\Services\Article\Processor\ArticleProcessor;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class InfoAction extends BaseAction
{
    use ApiActionTrait;

    protected $_article = null;
    protected $_type = 0;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $workNo = $httpTool->getBothSafeParam('work_no', HttpConfig::PARAM_NUMBER_TYPE);
        $this->_type = $httpTool->getBothSafeParam('type', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_article = Article::find($id);
            if (!empty($this->_article)) {
                $this->_type = $this->_article->type;
            }
        }
        if ($workNo == 1 || $workNo == 2) {
            if ($workNo == 1) {
                if (empty($this->_article) && $this->_type <= 0) {
                    $this->redirect("文章类型不能为空");
                }
                return $this->showInfo();
            } else {
                if ($this->_type <= 0) {
                    $this->errorJson(500, '文章类型不能为空');
                }
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
        $content = $httpTool->getBothSafeParam('content');
        $publishedAt = $httpTool->getBothSafeParam('pubdate');
        $picPreview = $this->request->get('list_pic_preview');
        $title = trim($title);
        $publishedAt = trim($publishedAt);
        if(empty($title)){
            $this->errorJson(500, '标题不能为空');
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

    protected function save($data)
    {
        $processor = new ArticleProcessor();
        list($status, $article) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '学校创建失败');
        }
        $this->successJson();
    }

    protected function update($data)
    {
        $processor = new ArticleProcessor();
        $processor->update($this->_article->id, $data);
        $this->successJson();
    }
}