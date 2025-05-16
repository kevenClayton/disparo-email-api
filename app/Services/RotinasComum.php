<?php

namespace App\Services;


use App\Enums\FormaDePagamento;
use App\Enums\TipoLink;
use App\Enums\TipoNotificacaoAdministrativa;
use App\Enums\URL;
use App\Jobs\EnviarEmailGenericoJob;
use App\Jobs\EnviarEmailJob;
use App\Jobs\EnviarMensagemWhatsapp;
use App\Jobs\EnviarTemplateWhatsapp;
use App\Models\Cobrancas;
use App\Models\ConfiguracaoWhatsapp;
use App\Models\Estabelecimento;
use App\Models\LinkCurto;
use App\Models\Notificacao;
use App\Models\Usuario;
use App\Services\Whatsapp\Templates\EnviarTemplate;
use App\Services\Whatsapp\WhatsappBaseServico;
use App\Services\Whatsapp\WppConnectServico;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Throwable;

class RotinasComum
{
    public static function validarEmail($email)
    {
        if (!$email) {
            return false;
        }

        $email = trim($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            return false;
        }

        $dominio = substr(strrchr($email, "@"), 1);
        if (!checkdnsrr($dominio, 'MX')) {
            return false;
        }

        $dominioAceitaEmail = self::dominioAceitaEmail($email);
        if (!$dominioAceitaEmail) {
            return false;
        }

        return true;
    }
    public static function dominioAceitaEmail($email)
    {
        $dominio = substr(strrchr($email, "@"), 1);

        $registros = dns_get_record($dominio, DNS_MX);

        if (empty($registros)) {
            return false;
        }

        foreach ($registros as $mx) {
            if (isset($mx['target']) && $mx['target'] === '.') {
                return false;
            }
        }

        return true;
    }

    public static function separadoPorVirgulaEmArray($itens)
    {
        if(empty($itens)){
            return null;
        }
        $itens = array_map('trim', explode(',', $itens));

        return $itens;
    }
}
