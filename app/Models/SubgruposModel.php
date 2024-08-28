<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SubgruposModel extends Model
{
    use HasFactory;

    protected $table = 'subgrupos';
    protected $primaryKey = 'id_subgrupo';

    protected $fillable = [
        'id_subgrupo',
    	'nombre_subgrupo',
		'descripcion_subgrupo',
        'codigo_subgrupo',
        'prefijo',
        'creado_por',
        'actualizado_por',
        'id_grupo'
    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcioon para formateo de la fecha

    public static function DetalleSubgrupos() {

        return DB::table('subgrupos as a')
                    ->join('grupos as b', 'b.id_grupo', '=', 'a.id_grupo')
                    ->select('a.codigo_subgrupo',
                            'a.nombre_subgrupo',
                            'b.codigo_grupo',
                            'b.nombre_grupo')
                    ->get();
    }

    public static function SubgruposPorGrupo($IdGrupo)
    {
        return DB::table('subgrupos as s')
                ->join('grupos as g', 's.id_grupo', '=', 'g.id_grupo')
                ->select(
                        's.id_subgrupo',
                        's.codigo_subgrupo',
                        's.nombre_subgrupo',
                        'g.codigo_grupo',
                        'g.nombre_grupo')
                ->where('g.id_grupo', '=', $IdGrupo)
                ->orWhere('g.codigo_grupo', '=', $IdGrupo)
                ->get();
    }

    //Relacion de con grupos
    public function grupo()
    {
        return $this->belongsTo(GruposModel::class, 'id_grupo');
    }
    //Relacion de con articulo
    public function articulos()
    {
        return $this->hasMany(ArticulosModel::class, 'id_articulo');
    }

}
