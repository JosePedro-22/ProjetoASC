<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'nome',
        'sobrenome',
        'email',
        'telefone',
        'endereco',
        'cidade',
        'cep',
        'data_nascimento'
    ];

    public function campaign():BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
