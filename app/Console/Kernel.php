<?php

namespace App\Console;

use App\Console\Commands\ActualizarTasaDolarBCV;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\CnthEnviarCorreosHerramientasPendientesCommand;
use App\Console\Commands\CompOcInternacionalCostoCeroCommand;
use App\Console\Commands\InveEnviarCorreoPuntoPedidoArticulosCommand;
use App\Console\Commands\InveEnviarCorreoStockMinimoArticulosCommand;
use App\Console\Commands\SolsFinalizarSolicitudesCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //ENVIO DE CORREO AUTOMATICO TODOS LOS DIAS A LAS 3:50 DE LA TARDE , HERRAMIENTAS CON RECEPCION PENDIENTES
        $schedule->command(CnthEnviarCorreosHerramientasPendientesCommand::class)->dailyAt('15:50')->runInBackground();

        //FINALIZAR SOLICITUDES DE SERVICIO AUTOMATICAMENTE, ESTATUS CERRADO MAYOR O IGUAL A 5 DIAS. DIARIO A LAS 4 PM
        $schedule->command(SolsFinalizarSolicitudesCommand::class)->dailyAt('16:00')->runInBackground(); 

        // ACTUALIZAR TASA DOLAR OBTENIDO DE LA PAGINA DEL BCV
        $schedule->command(ActualizarTasaDolarBCV::class)->dailyAt('6:00')->runInBackground(); 

        // //ENVIO DE CORREO AUTOMATICO TODOS LOS DIAS A LAS 8:00 DE LA MAÑANA , ARTICULOS CON STOCK MINIMO
        // $schedule->command(InveEnviarCorreoStockMinimoArticulosCommand::class)->dailyAt('8:00')->runInBackground();

        //ENVIO DE CORREO AUTOMATICO TODOS LOS DIAS A LAS 8:00 DE LA MAÑANA , ARTICULOS CON PUNTO PEDIDO
        $schedule->command(InveEnviarCorreoPuntoPedidoArticulosCommand::class)->dailyAt('8:00')->runInBackground();

        //ENVIO DE CORREO AUTOMATICO TODOS LOS DIAS A LAS 8:00 DE LA MAÑANA , OC INTERNACIONALES CON COSTO CERO
        $schedule->command(CompOcInternacionalCostoCeroCommand::class)->dailyAt('8:00')->runInBackground();
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
