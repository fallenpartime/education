<?php

namespace Admin\Models\System;

use Illuminate\Database\Eloquent\Model;

class AdminUserInfo extends Model
{
    protected $table = "admin_user_infos";
    protected $appends = ['edit_url'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function role()
    {
        return $this->hasOne(AdminUserRole::class, 'role_no', 'role_id');
    }
}
