<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
	protected $table = 'contracts';
	protected $fillable = ['number'];

	public function appendixes()
    {
        return $this->hasMany('App\Models\Appendix');
    }

    public function files()
    {
        return $this->morphMany('App\Models\File', 'fileable');
    }
}
