<?php

namespace App\Jobs;

use App\Enums\StatusEmail;
use App\Mail\EnviarEmailConteudoGenerico;
use App\Services\RotinasComum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EnviarEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $emailDisparar;
     public $destinatario;
    public function __construct($emailDisparar, $destinatario)
    {
        $this->destinatario = $destinatario;
        $this->emailDisparar = $emailDisparar;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            $emailValido = RotinasComum::validarEmail($this->destinatario);
            if (!$emailValido) {
                Log::warning('Email inválido: ' . $this->destinatario);
                return;
            }

            Mail::raw($this->emailDisparar->conteudo, function ($message) {
                $message->to($this->destinatario->email)
                        ->from($this->emailDisparar->remetente)
                        ->subject($this->emailDisparar->titulo);
            });

            $this->destinatario->update([
                'situacao' => StatusEmail::ENVIADO,
                'enviado_em' => now()
            ]);
        } catch (\Throwable $e) {
            $this->destinatario->update([
                'situacao' => StatusEmail::ERRO
            ]);
            Log::error("Erro ao enviar e-mail: " . $e->getMessage());
        }


    }
}
