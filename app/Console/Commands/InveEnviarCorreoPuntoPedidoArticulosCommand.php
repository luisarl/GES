<?php

namespace App\Console\Commands;

use App\Mail\InvePuntoPedidoArticulosMailable;
use App\Models\CorreosModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InveEnviarCorreoPuntoPedidoArticulosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inve:punto-pedido';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar Correo Punto Pedido Articulos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $almacenes = [1,2,3]; // 1 = Mantenimiento, 2 = Principal, 3 = Embarcaciones

        $empresa = DB::table('almacenes as a')
            ->join('empresas as e', 'a.id_empresa', '=', 'e.id_empresa')
            ->select(
                'a.id_almacen',
                'a.nombre_almacen',
                'a.id_empresa',
                'e.nombre_empresa',
                'e.base_datos',
            )
            ->whereIn('a.id_almacen', $almacenes)
            ->get();

        foreach($empresa as $empresa)
        {

            $articulos = DB::connection('profit')
            ->table($empresa->base_datos.'.dbo.vArticulosPuntoPedido')
            ->select(
                'co_art',
                'art_des',
                'uni_venta',
                DB::raw('CAST(stock_act AS DECIMAL(10,2)) as stock_actual'),
                DB::raw('CAST(pto_pedido AS DECIMAL(10,2)) as punto_pedido'),
                DB::raw('CAST(stock_ped AS DECIMAL(10,2)) as stock_pedido'),
                DB::raw('CAST(stock_lle AS DECIMAL(10,2)) as stock_lle'),
                'procedenci'
            )
            ->get();

            $destinatarios = CorreosModel::InvCorreoPuntoPedidoArticulos($empresa->id_almacen);

            Mail::to($destinatarios[0]) //DESTINATARIOS
            ->cc($destinatarios[1]) //EN COPIA
            ->bcc($destinatarios[2]) // EN COPIA OCULTA
            ->later(now()->addSeconds(10), new InvePuntoPedidoArticulosMailable($articulos, $empresa));
        }
    }
}
