<?php

namespace App\Services;

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
