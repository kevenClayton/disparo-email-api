<?php

namespace App\Services;

use App\Jobs\EnviarEmailJob;


class EmailDisparoService
{
    public function enviar($emailDisparar, $destinatario)
    {
        EnviarEmailJob::dispatch($emailDisparar, $destinatario)->onQueue('emails');
    }
    public function tratarDestinatarios($destinatarios)
    {
        if(empty($destinatarios)){
            return null;
        }
        $destinatarios = array_map('trim', explode(',', $destinatarios));
        $destinatarios = array_map('strtolower', $destinatarios);

        return $destinatarios;
    }
}
