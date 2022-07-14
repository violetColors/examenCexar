<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index()
    {
            $alumnos = Alumno::all();
            return response([
                'total_data' => count($alumnos),
                'data' => $alumnos
            ]);
    }

    public function estadisticas (Request $Request)
    {

        $masculino =  Alumno::where("genero","M")->count();
        $femenino =  Alumno::where("genero","F")->count();

        return response([
            'masculinos'=>$masculino,
            'femeninos'=>$femenino,
        ]);
    }

    public function beca (Request $Request)
    {

        $becado =  Alumno::where("becado","si")->count();
        $nbecado =  Alumno::where("becado","no")->count();

        return response([
            'Si'=>$becado,
            'No'=>$nbecado,
        ]);
    }

    public function horario (Request $Request)
    {

        $matutino =  Alumno::where("horario","matutino")->count();
        $vespertino =  Alumno::where("horario","vespertino")->count();

        return response([
            'matutino'=>$matutino,
            'vespertino'=>$vespertino,
        ]);
    }

    public function calificacion (Request $Request)
    {

        $reprobados =  Alumno::where("calificacion_prepa", "<=", "6")->count();
        $aprobados =  Alumno::where("calificacion_prepa",">=", "7")->count();

        return response([
            'reprobados' => $reprobados,
            'aprobados' => $aprobados,
        ]);
    }

    public function problemas (Request $Request)
    {

        $nprobelmas =  Alumno::where("problemas_de_salud","No")->count();
        $problemas =  Alumno::where("problemas_de_salud","Si")->count();

        return response([
            'sin_problemas_de_salud'=>$nprobelmas,
            'problemas_de_salud'=>$problemas,
        ]);
    }


    public function create(Request $Request)
    {
        $data =$this->rules($Request);
        Alumno::create($data);
        return response([
            'message' => 'se creo con exito'
        ]);
    }

    public function show($id)
    {
        $alumno = Alumno::where('_id',$id)->first();
        return response($alumno);
    }

    public function update($id, Request $Request)
    {
            $data = $this->rules($Request);
            Alumno::find($id)->fill($data)->save();
            return response([
                'message' => 'se modifico'
            ]);
    }

    public function delete($id)
    {
            Alumno::find($id)->delete();
            return response([
                'message' => 'Borrado'
            ]);
    }
    protected function rules($Request){
     return $this->validate($Request,[
            'nombre' => 'required',
            'edad' => 'required',
            'genero' => 'required',
            'carrera' => 'required',
            'etnia_indigena' => 'required',
            'horario' => 'required',
            'calificacion_prepa' => 'required',
            'becado' => 'required',
            'problemas_de_salud' => 'required',

        ]);
    }
}
