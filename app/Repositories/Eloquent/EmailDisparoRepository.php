<?php

namespace App\Repositories\Eloquent;

use App\Models\EmailDestinarios;
use App\Models\EmailDisparo;
use App\Repositories\Interfaces\EmailDisparoRepositoryInterface;
use App\Services\RotinasComum;

class EmailDisparoRepository implements EmailDisparoRepositoryInterface
{
    public function obterTodos()
    {
        return EmailDestinarios::with('disparo')->get();
    }
    public function buscarPorCodigo($codigo){
        return EmailDisparo::with('disparo')->find($codigo);
    }
    public function criar(array $data, array|null|string $destinatarios = null){
        $emailDisparado = EmailDisparo::create($data);
        $emailsDestinatarios = RotinasComum::separadoPorVirgulaEmArray($destinatarios);

        if (!empty($emailsDestinatarios)) {
            foreach ($emailsDestinatarios as $destinatario) {
                $emailDisparado->destinatarios()->create([
                    'email' => $destinatario
                ]);
            }
        }
        return $emailDisparado;
    }
}
