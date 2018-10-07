<?php

namespace Admin\Models\School;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $table = "schools";
    protected $appends = ['edit_url'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function district()
    {
        return $this->belongsTo(SchoolDistrict::class, 'district_no', 'no');
    }
}
