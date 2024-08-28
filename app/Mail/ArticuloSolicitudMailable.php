<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class ArticuloSolicitudMailable extends Mailable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subject = "Solicitud De Migración De Articulo a Profit";

    public $articulo;
    public $empresas;
    public $usuario;

    public function __construct($articulo, $empresas, $usuario)
    {
        $this->articulo = $articulo;
        $this->empresas = $empresas;
        $this->usuario = $usuario;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.ArticuloSolicitud');
    }
}
