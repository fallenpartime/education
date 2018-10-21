<?php
/**
 * 活动图片
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Activity\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\Activity\ActivityPicture;

class ActivityPictureProcessor extends BaseProcessor
{
    protected $tableName = 'activity_pictures';
    protected $tableClass = ActivityPicture::class;
}