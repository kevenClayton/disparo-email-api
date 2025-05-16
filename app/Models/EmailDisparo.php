<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailDisparo extends Model
{
    use HasFactory;

    protected $table = 'emails_disparos';
    protected $primaryKey = 'codigo';
    protected $guarded = [];
    protected $appends = [];

    public function destinatarios()
    {
        return $this->hasMany(EmailDestinarios::class, 'codigo_disparo', 'codigo');
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
}
