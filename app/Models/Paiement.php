<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = ['user_id','chapter_id','methode','numero','montant','statut'];

    public function user(){ return $this->belongsTo(\App\Models\User::class); }
    public function chapter(){ return $this->belongsTo(\App\Models\Chapter::class); }
}
