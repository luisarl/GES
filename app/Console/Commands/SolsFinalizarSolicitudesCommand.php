<?php

namespace App\Console\Commands;

use App\Models\Sols_SolicitudesModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SolsFinalizarSolicitudesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sols:finalizarsolicitudes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finalizar Solicitudes Estatus Cerrado Mayor a 5 Dias';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $solicitudes = Sols_SolicitudesModel::SolicitudesCerradasMayor5Dias();
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); 
        
        foreach($solicitudes as $solicitud)
        {
           //ACTUALIZA LA TABLA SOLICITUDES
           Sols_SolicitudesModel::where('id_solicitud', '=', $solicitud->id_solicitud )
           ->update([
                    'estatus' => 'FINALIZADO', 
                    'fecha_finalizacion' => $FechaActual,
                    'finalizado_por' => 1
                ]); 
        }
    }
}
