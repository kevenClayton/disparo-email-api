<?php

namespace App\Models;

use App\Enums\StatusEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailDestinarios extends Model
{
    use HasFactory;
    protected $table = 'email_destinatarios';
    protected $primaryKey = 'codigo';
    protected $guarded = [];
    protected $appends = ['situacao_amigavel', 'cor_status', 'icone_status'];

    public function disparo()
    {
        return $this->belongsTo(EmailDisparo::class, 'codigo_disparo', 'codigo');
    }

    public function getSituacaoAmigavelAttribute()
    {
        return StatusEmail::descricaoAmigavel($this->situacao);
    }
    public function getCorStatusAttribute()
    {
        return StatusEmail::corStatus($this->situacao);
    }
    public function getIconeStatusAttribute()
    {
        return StatusEmail::iconeStatus($this->situacao);
    }

    public function getCreatedAtAttribute($value)
    {
        if(empty($value)) {
            return null;
        }
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
    public function getUpdatedAtAttribute($value)
    {
        if(empty($value)) {
            return null;
        }
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }

    function getEnviadoEmAttribute($value)
    {
        if(empty($value)) {
            return null;
        }
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
