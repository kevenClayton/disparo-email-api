<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailDisparoRequest;
use App\Http\Requests\EmailDisparoAtualizarRequest;
use App\Repositories\Interfaces\EmailDisparoRepositoryInterface;
use App\Services\EmailDisparoService;

class EmailDisparoController extends Controller
{
    protected $emailDisparo;
    protected $emailDisparoServico;
    public function __construct(EmailDisparoRepositoryInterface $emailDisparo, EmailDisparoService $emailDisparoServico)
    {
        $this->emailDisparo =  $emailDisparo;
        $this->emailDisparoServico = $emailDisparoServico;
    }
    public function listar()
    {
        $emails = $this->emailDisparo->obterTodos();
        return response()->json($emails);
    }
    public function enviar(EmailDisparoRequest $request)
    {
        $data = $request->except('destinatario');
        $destinatario = $request->input('destinatario');
        $emailDisparar = $this->emailDisparo->criar($data, $destinatario);
        $destinatarios = $emailDisparar->destinatarios;

        foreach ($destinatarios as $destinatario) {
            $this->emailDisparoServico->enviar($emailDisparar, $destinatario);
        }

        return response()->json($emailDisparar, status: 200);
    }

}
