<?php

namespace App\Http\Controllers;

use App\folder;
use App\user;
use Illuminate\Http\Request;
use Validator;

class FoldersControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        // $folders = folder::all();
        // $data = $folders->toArray();

        $folders = folder::where('id_subcarpeta',null)->get();

        foreach($folders as $key => $value){
            $folders[$key] = $this->getSubs($value);
        }

        $folders->toArray();

        $response = [
            'success' => true,
            'data' => $folders,
            'message' => 'Folders.'
        ];

        return response()->json($response, 200);
    }

    public function getSubs($model){
        $model->folders;
        foreach ($model['folders'] as $key => $value) {
            $model['folders'][$key] = $this->getSubs($value);
        }
        return $model;
    }

    public function allFolders(){

          $folders = folder::all();
          $data = $folders->toArray();

           $response = [
            'success' => true,
            'data' => $folders,
            'message' => 'Folders.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campos = $request->all();

        $validator = Validator::make($campos, [
            'nombrecarpeta' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $folder = folder::create($campos);
        $data = $folder->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Carpeta creada exitosamente!'
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $folder = folder::find($id);
        $data = $folder->toArray();

        if (is_null($folder)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Carpeta no encontrada.'
            ];
            return response()->json($response, 404);
        }

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Carpeta encontrada exitodamente.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $folder = folder::findOrFail($id);

        $campos = $request->all();

        $validator = Validator::make($campos, [
            'nombrecarpeta' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $folder->nombrecarpeta = $request->nombrecarpeta;
        $folder->id_subcarpeta = $request->id_subcarpeta;
        $folder->user_id       = $request->user_id;

        $folder->save();
        $data = $folder->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Carpeta actualizada exitosamente.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = folder::destroy($id);

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Carpeta eliminada con exito successfully.'
        ];

        return response()->json($response, 200);
    }
}
