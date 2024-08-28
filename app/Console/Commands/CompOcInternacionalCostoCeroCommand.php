<?php

namespace App\Console\Commands;

use App\Mail\CompOcInternacionalCostoCeroMailable;
use App\Models\CorreosModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CompOcInternacionalCostoCeroCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comp:ocinternacional-costocero';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar Correo con listado de OC internacionales con costo cero';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $articulos = DB::connection('profit')
            ->table('MasterProfit.dbo.VCOM_OCINTERNACIONALCOSTOCERO')
            ->select(
                'OC',
                'FechaOC',
                'Codigo',
                'Articulo',
                'Cantidad',
                'CostoUnitUS'
            )
            ->get();

            $destinatarios = CorreosModel::CompCorreoOcInternacionalCostoCero();


            Mail::to($destinatarios[0]) //DESTINATARIOS
            ->cc($destinatarios[1]) //EN COPIA
            ->bcc($destinatarios[2]) // EN COPIA OCULTA
            ->later(now()->addSeconds(10), new CompOcInternacionalCostoCeroMailable($articulos));
    }
}
