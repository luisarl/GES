<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CnthDespachosMailable extends Mailable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subject = "Despacho de Herramientas";

    public $movimiento;
    public $herramientas;

    public function __construct($movimiento, $herramientas)
    {   
        $this->movimiento = $movimiento;
        $this->herramientas = $herramientas;
    }

    public function build()
    {
        return $this->view('emails.ControlHerramientas.Despacho');
    }

}
