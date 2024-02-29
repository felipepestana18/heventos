<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // estou definido que items vai ser um array
    protected $casts =[
        "items" => "array"
    ];

    // estou falando para o laravel que esse campo é uma data
    protected $dates = ['date'];

    // aqui na hora do update não dar deixaar salvar a token no banco de dados para dar certo
    protected $guarded = [];

    // estou falando que um evento está atrelado ao  evento
    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    // muitos para muitos
    public function users(){
        return $this->belongsToMany('App\Models\User');
    }
}
