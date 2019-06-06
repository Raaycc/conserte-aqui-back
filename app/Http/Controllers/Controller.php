<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function criarUsuario(Request $request)
    {
        try {
            $this->validate($request, [
                'login' => 'required',
                'password' => 'required',
                'name' => 'required',
            ]);

            $data = $request->only('login', 'password', 'name');

            $data['nivel'] = 'usuario';

            $usuario = User::query()->create($data);

        } catch (\Throwable $e) {
            return response()->json(['erro' => 'não foi possível entrar no sistema', 'ERRO' => $e->getMessage()], 400);
        }


        return response()->json([
            'usuario' => $usuario
        ], 201);
    }

    public function criarFornecedor(Request $request)
    {
        try {
            $this->validate($request, [
                'login' => 'required',
                'password' => 'required',
                'name' => 'required',
                'especialidade' => 'required',
            ]);

            $data = $request->only('login', 'password', 'name', 'especialidade');

            $data['nivel'] = 'fornecedor';

            $usuario = User::query()->create($data);

        } catch (\Throwable $e) {
            return response()->json(['erro' => 'não foi possível entrar no sistema', 'ERRO' => $e->getMessage()], 400);
        }


        return response()->json([
            'usuario' => $usuario
        ], 201);
    }

    public function listaFornecedor(Request $request)
    {

        $listaFornecedor = User::query()->where('nivel', 'fornecedor')->get();

        return response()->json([
            'usuario' => $listaFornecedor
        ], 201);
    }

    public function mandaMensagem(Request $request)
    {
        try {
            $usuario = auth()->user();

            $this->validate($request, [
                'fornecedor_id' => 'required',
                'msg' => 'required'
            ]);

            $data = $request->only( 'fornecedor_id', 'msg');

            $data['usuario_id'] = $usuario->id;

            $msg = Chat::query()->create($data);

        } catch (\Throwable $e) {
            return response()->json(['erro' => 'não foi possível entrar no sistema', 'ERRO' => $e->getMessage()], 400);
        }


        return response()->json([
            'msg' => $msg
        ], 201);
    }

    public function mandaMensagemFornecedor(Request $request)
    {
        try {
            $usuario = auth()->user();

            $this->validate($request, [
                'usuario_id' => 'required',
                'msg' => 'required'
            ]);

            $data = $request->only( 'usuario_id', 'msg');

            $data['fornecedor_id'] = $usuario->id;

            $msg = Chat::query()->create($data);

        } catch (\Throwable $e) {
            return response()->json(['erro' => 'não foi possível entrar no sistema', 'ERRO' => $e->getMessage()], 400);
        }


        return response()->json([
            'msg' => $msg
        ], 201);
    }

    public function receberChatsUsuario(Request $request)
    {
        $usuario = auth()->user();

        $listaFornecedor = Chat::query()->where('usuario_id', $usuario->id)->get();

        $listaFornecedor->groupBy('fornecedor_id');



        return response()->json([
            'lista' => $listaFornecedor
        ], 201);
    }

    public function receberChatsFornecedor(Request $request)
    {
        $usuario = auth()->user();

        $listaFornecedor = Chat::query()->where('fornecedor_id', $usuario->id)->get();

        $listaFornecedor->groupBy('usuario_id');



        return response()->json([
            'lista' => $listaFornecedor
        ], 201);
    }
}
