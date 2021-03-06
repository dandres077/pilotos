<?php

namespace App\Http\Controllers;

use App\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class ModeloController extends Controller
{
/*
}
|--------------------------------------------------------------------------
| index
|--------------------------------------------------------------------------
|
*/

    public function index()
    {
        $data = DB::table('modelos')
            ->leftJoin('marcas', 'modelos.marca_id', '=', 'marcas.id')
            ->select(
                'modelos.*',
                'marcas.nombre as nom_marca',
                DB::raw('(CASE WHEN modelos.status = 1 THEN "Activo" ELSE "Inactivo" END) AS estado_elemento'))
            ->where('modelos.status', '<>', 3 )
            ->orderByRaw('modelos.id ASC')
            ->get();

        $titulo = 'Modelos';

        return view('modelos.index', compact('data', 'titulo'));
    }


/*
|--------------------------------------------------------------------------
| create
|--------------------------------------------------------------------------
|
*/

    public function create()
    {
        $marcas = DB::table('marcas')->select('marcas.*')->where('status', 1 )->get();
        $titulo = 'Modelos';

        return view('modelos.create', compact('titulo', 'marcas'));
    }


/*
|--------------------------------------------------------------------------
| store
|--------------------------------------------------------------------------
|
*/
    public function store(Request $request)
    {

        $request['user_create'] = Auth::id();
        $data = Modelo::create($request->all());

        return redirect ('admin/modelos')->with('success', 'Registro creado exitosamente');
    }


/*
|--------------------------------------------------------------------------
| edit
|--------------------------------------------------------------------------
|
*/

    public function edit($id)
    {

        $data = Modelo::find($id); 
        $marcas = DB::table('marcas')->select('marcas.*')->where('status', 1 )->get();       
        $titulo = 'Modelos';

        return view ('modelos.edit')->with (compact('data', 'titulo', 'marcas'));
    }



/*
|--------------------------------------------------------------------------
| update
|--------------------------------------------------------------------------
|
*/
    public function update(Request $request, $id)
    {

        $data = Modelo::find($id);
        $data->marca_id = $request->input('marca_id');
        $data->nombre = $request->input('nombre');
        $data->user_update = Auth::id();
        $data->save();

        
        return redirect ('admin/modelos')->with('success', 'Registro actualizado exitosamente');
    }



/*
|--------------------------------------------------------------------------
| Activar publicación
|--------------------------------------------------------------------------
|
*/

    public function active($id)
    {

        $data = Modelo::find($id);
        $data->status = 1;
        $data->user_update = Auth::id();
        $data->save();
  
        return redirect ('admin/modelos');
    }


/*
|--------------------------------------------------------------------------
| Desactivar publicación
|--------------------------------------------------------------------------
|
*/

    public function inactive($id)
    {
        $data = Modelo::find($id);
        $data->status = 2;
        $data->user_update = Auth::id();
        $data->save();

        return redirect ('admin/modelos');
    }

/*
|--------------------------------------------------------------------------
| destroy
|--------------------------------------------------------------------------
|
*/

public function destroy($id)
{
    $data = Modelo::find($id);
    $data->status = 3;
    $data->user_update = Auth::id();
    $data->save();

    return redirect ('admin/modelos')->with('eliminar', 'ok');
}
}