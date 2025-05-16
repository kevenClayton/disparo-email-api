<?php

namespace App\Repositories\Interfaces;

interface EmailDisparoRepositoryInterface
{
    public function obterTodos();
    public function buscarPorCodigo($codigo);
    public function criar(array $data, array|null $destinatarios = null);
}
