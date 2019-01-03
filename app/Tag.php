<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable= ['name','searched'];
    protected $hidden = ['pivot'];
    public function conteudos()
    {
        return $this->belongsToMany('App\Conteudo');
    }
}
