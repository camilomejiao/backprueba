<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Google_Client;

class UsersControllers extends Controller
{

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                 => 'required',
            'lastname'             => 'required',
            'tipoidentificacion'   => 'required',
            'numeroidentificacion' => 'required',
            'email'                => 'required|email',
            'password'             => 'required',
            'c_password'           => 'required|same:password',
        ]);

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $User = User::create($input);
        $success['token'] = $User->createToken('MyApp')->accessToken;
        $success['name']  = $User->name;
        $success['rol']   = $User->rol;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User register successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;

            return response()->json([
                'id' => $user->id,
                'usuario' => $user,
                'token' => $success['token'],
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Login de google
     */
    public function logingoogle(Request $request){
        return $request->token;
        //$client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
        $client = new Google_Client(['client_id' => '1013666993265-9g8irupkcjv2o3439u6ltntdlhtg4qsb.apps.googleusercontent.com']);
        return $client;

        $payload = $client->verifyIdToken($id_token);
        return $payload . 'ok';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Users = User::all();
        $data = $Users->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Usuarios.'
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
        $User = new User();

        $User->name               = $request->name;
        $User->lastname           = $request->lastname;
        $User->email              = $request->email;
        $User->tipoidentificacion = $request->tipoidentificacion;
        $User->numeroidentificacion = $request->numeroidentificacion;
        $User->password           =  bcrypt($request->password);
        $User->rol                = $request->rol;

        $User->save();

        $response = [
            'success' => true,
            'data' => $User,
            'message' => 'Usuario Registrado!'
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
        $User = User::findOrFail($id);

        $response = [
            'success' => true,
            'data' => $User,
            'message' => 'Usuario Registrado!'
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
     * @param  \App\User;
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $User = User::findOrFail($id);
        //$User->update($request->all());

        $User->name                 = $request->name;
        $User->lastname             = $request->lastname;
        $User->email                = $request->email;
        $User->tipoidentificacion   = $request->tipoidentificacion;
        $User->numeroidentificacion = $request->numeroidentificacion;
        $User->password           =  bcrypt($request->password);

        $User->save();

        $response = [
            'success' => true,
            'data' => $User,
            'message' => 'Usuario Modificado.'
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
        $User = User::destroy($id);

        $response = [
            'success' => true,
            'data' => $User,
            'message' => 'Usuario Eliminado.'
        ];

        return response()->json($response, 200);
    }
}
