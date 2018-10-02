<?php
/**
 *
 * Date: 2018/10/2
 * Time: 23:02
 */
namespace Admin\Actions;

use Frameworks\Tool\Http\HttpTool;
use Illuminate\Http\Request;

class BaseAction
{
    protected $request = null;
    protected $httpTool = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function getHttpTool()
    {
        if (empty($this->httpTool)) {
            $this->httpTool = new HttpTool($this->request);
        }
        return $this->httpTool;
    }

    public function run()
    {}
}