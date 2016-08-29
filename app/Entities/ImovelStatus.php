<?php

namespace FinxiImoveis\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ImovelStatus extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "imoveis_status";
    protected $fillable = [];


    public function imoveis()
    {
        return $this->hasMany(Imovel::class,'imoveis_status_id','id');
    }
}
