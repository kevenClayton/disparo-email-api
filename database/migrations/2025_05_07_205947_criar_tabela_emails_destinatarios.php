<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_destinatarios', function (Blueprint $table) {
            $table->id('codigo');
            $table->foreignId('codigo_disparo')->constrained('emails_disparos','codigo')->onDelete('cascade');
            $table->string('email', 100);
            $table->enum('situacao', ['pendente', 'enviado', 'erro'])->default('pendente');
            $table->timestamp('enviado_em')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_destinatarios');
    }
};
