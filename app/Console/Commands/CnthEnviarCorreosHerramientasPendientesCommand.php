<?php

namespace App\Console\Commands;

use App\Mail\CnthHerramientasRecepcionPendienteMailable;
use App\Models\Cnth_HerramientasModel;
use App\Models\CorreosModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CnthEnviarCorreosHerramientasPendientesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cnth:enviarcorreo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia Correo del Modulo Control de Herramientas';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $almacenes = [1,2,3]; // 1 = Mantenimiento, 2 = Principal, 3 = Embarcaciones

        for($i = 0; $i < count($almacenes); $i ++)
        {
            $destinatarios = CorreosModel::CnthCorreoHerramientasRecepcionPendiente($almacenes[$i]);
        
            $herramientas = Cnth_HerramientasModel::HerramientasRecepcionPendienteAlmacen($almacenes[$i]);

            Mail::to($destinatarios[0]) //DESTINATARIOS
            ->cc($destinatarios[1]) //EN COPIA
            ->bcc($destinatarios[2]) // EN COPIA OCULTA
            ->later(now()->addSeconds(10), new CnthHerramientasRecepcionPendienteMailable($herramientas));
        }
    }
}
