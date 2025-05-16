<?php

namespace Tests\Feature;

use App\Jobs\EnviarEmailJob;
use App\Models\EmailDisparo;
use App\Models\EmailDestinarios;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class EmailDisparoTest extends TestCase
{
    use RefreshDatabase;

    public function test_listar_emails()
    {

        $response = $this->getJson('/api/email-disparo');

        $response->assertStatus(200);
    }

    public function test_cadastrar_disparo()
    {
        Queue::fake();
        $remetente = 'keven.developer@gmail.com';

        $data = [
            'remetente' => 'keven.developer@gmail.com',
            'titulo' => 'Título teste',
            'corpo' => 'Corpo teste',
            'destinatario' => 'keven.santos@gmail.com, kevenclaytonalves@hotmail.com'
        ];

        $response = $this->postJson('/api/email-disparo', $data);
        $response->assertStatus(200)
                 ->assertJsonFragment(['remetente' => $remetente]);

        $this->assertDatabaseHas('emails_disparos', ['remetente' => $remetente]);

    }

    public function test_exporta_emails_para_excel()
    {
        $response = $this->get('/api/exportacao/excel?tipoExportacao=EmailDisparo');

        $response->assertStatus(200)
                 ->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_dispara_email_na_fila()
    {
        Queue::fake();

        $data = [
            'remetente' => 'keven.developer@gmail.com',
            'titulo' => 'Título teste',
            'corpo' => 'Corpo teste',
            'destinatario' => 'keven.santos@gmail.com, kevenclaytonalves@hotmail.com'
        ];

        $this->postJson('/api/email-disparo', $data);
        $this->postJson('/api/email-disparo', $data);
        Queue::assertPushed(EnviarEmailJob::class);

    }
}
