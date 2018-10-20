<?php

namespace Admin\Models\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityQuestion extends Model
{
    use SoftDeletes;

    protected $table = "activity_questions";
    protected $appends = ['edit_url', 'operate_list'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }
}
