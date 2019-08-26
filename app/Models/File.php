<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = ['url','fileable_id','fillable_type'];

    public function filetable()
    {
        return $this->morphTo();
    }
}
