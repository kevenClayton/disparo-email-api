<?php

namespace App\Enums;

class StatusEmail  {
    const ENVIADO = 'enviado';
    const PENDENTE = 'pendente';
    const ERRO = 'erro';


    public static function descricaoAmigavel($enum) {
        return match ($enum) {
            self::ENVIADO  => 'Enviado',
            self::PENDENTE => 'Pendente',
            self::ERRO     => 'Erro',
            default        => $enum,
        };
    }
    public static function corStatus($enum) {
        return match ($enum) {
            self::ENVIADO  => 'text-green-500',
            self::PENDENTE => 'text-yellow-500',
            self::ERRO     => 'text-red-500',
            default        => 'text-gray-500',
        };
    }
    public static function iconeStatus($enum) {
        return match ($enum) {
            self::ENVIADO  => 'lucide-check',
            self::PENDENTE => 'lucide-clock',
            self::ERRO     => 'lucide-ban',
            default        => $enum,
        };
    }
}
