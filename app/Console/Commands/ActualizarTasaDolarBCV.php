<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ActualizarTasaDolarBCV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'actualizartasadolarbcv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene El valor del Dolar de la Pagina https://www.bcv.org.ve/';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = "https://www.bcv.org.ve/terminos-condiciones"; // URL del banco central
        $opts = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $context = stream_context_create($opts);
        $content = file_get_contents($url, false, $context);
        preg_match_all("/([0-9]+,[0-9]+)/", $content, $matches); // Buscamos varios números con una expresión regular
        $valor = str_replace(',', '.', $matches[1][4]); // Almacenamos el tercer número en una variable
        $fecha = date('d-m-Y'); // Fecha Actual
        $moneda = 'USD';
        
        //inserta en la tabla tasas
        DB::table('tasas')
            ->insert([
                    'moneda' => $moneda,
                    'valor' => $valor,
                    'fecha' => $fecha
                ]);
    }
}
