<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AsalSalidasCreateMailable extends Mailable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subject = "Nueva Autorización de Salida";

    public $salida;
    public $usuario;

    public function __construct($salida, $usuario)
    {
        $this->salida = $salida;
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.SalidaMateriales.SalidaCreate');
    }
}
