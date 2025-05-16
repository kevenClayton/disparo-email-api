<?php

namespace App\Exports;


use App\Models\EmailDestinarios;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;

class ExportarExcel implements FromCollection,WithHeadings,ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $model;
    protected $filtro;
    public function headings(): array
    {

        switch ($this->model) {
            case 'EmailDisparo':
                return $this->cabecalhoDisparo();
            default:
                return response()->json(['error' => 'Não encontrado'], 404);
        }
    }

    public function __construct($model, $filtro = null)
    {
        $this->model = $model;
        $this->filtro = $filtro;
    }


    public function collection()
    {
        switch ($this->model) {
            case 'EmailDisparo':
                return $this->exportarDisparo();
            default:
                return response()->json(['error' => 'Não encontrado'], 404);
        }
    }

    protected function cabecalhoDisparo(){
        return [
            'Título',
            'Corpo',
            'Remetente',
            'Destinatário',
            'Situação',
            'Enviado em'
        ];
    }

    protected function exportarDisparo()
    {
        $emailDestinatarios = EmailDestinarios::with('disparo')->get();

        return $emailDestinatarios->map(function ($destinatario) {
            $disparo = $destinatario->disparo;

            return [
                'titulo' => $disparo->titulo,
                'corpo' => $disparo->corpo,
                'remetente' => $disparo->remetente,
                'destinatario' => $destinatario->email,
                'situacao' => $destinatario->situacao,
                'enviado' => $destinatario->enviado_em,
            ];
        });
    }


    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);

    }

}
