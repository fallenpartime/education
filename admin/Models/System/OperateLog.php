<?php

namespace Admin\Models\System;

use Illuminate\Database\Eloquent\Model;

class OperateLog extends Model
{
    protected $table = "operate_logs";

    public function user()
    {
        return $this->belongsTo(AdminUser::class, 'user_id');
    }
}
