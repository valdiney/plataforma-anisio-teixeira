<?php

namespace App\Http\Controllers;

use App\Denuncia;
use App\User;
use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;
use Validator;
use App\Http\Controllers\ApiController;

class DenunciaController extends ApiController
{
    private $denuncia;
    protected $request;

    public function __construct(Request $request, Denuncia $denuncia)
    {
        $this->middleware('jwt.verify')->except(['list', 'create']);
        $this->denuncia = $denuncia;
        $this->request = $request;
    }
    /**
     * Lista de denúncias
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $limit = $this->request->query('limit', 15);
        $orderBy = ($this->request->has('order')) ? $this->request->query('order') : 'created_at';
        $page = ($this->request->has('page')) ? $this->request->query('page') : 1;

        $paginator = $this->denuncia::paginate($limit)->setPath("/denuncias?limit={$limit}");

        return $this->showAsPaginator($paginator, 'Lista de Denúncias', 200);
    }

    /**
     * Adiciona novas denúncias
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $validator = Validator::make($this->request->all(), config('rules.denuncia'));
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Não foi possível registrar a denúncia', 201);
        }

        $denuncia = $this->denuncia;

        $denuncia->name = $this->request->get('name');
        $denuncia->email = $this->request->get('email');
        $denuncia->url = $this->request->get('url');
        $denuncia->subject = $this->request->get('subject');
        $denuncia->message = $this->request->get('message');

        $resp = $denuncia->save();
        if (!$resp) {
            return $this->errorResponse([], 'Denúncia não registrada', 201);
        }

        $this->sendToAdminUsers(); // Envio de email a usuários admin e super admin

        return $this->successResponse([], 'Denúncia registrada com sucesso', 200);
    }

    private function sendToAdminUsers()
    {
        $users = User::whereRaw("options->>'role' = 'administrador' or options->>'role' = 'super administrador'")
            ->get();

        foreach ($users as $user) {
            Mail::send('emails', [], new SendMail($this->request), function ($message) use ($user) {
                $message->from('plataforma-b532cb@inbox.mailtrap.io', 'IAT - Instituto Anísio Teixeira');
                $message->to($user->email)->subject($this->request->subject);
            });
        }

        return true;
    }

    /**
     * Deleta as denúncias
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $denuncia = Denuncia::find($id);
        $resp = [];
        if (!$denuncia) {
            $resp = [
                'menssage' => 'Não foi possível deletar a denúncia',
                'success' => false,
            ];
        } else {
            $resp = [
                'menssage' => "Denúncia de id: {$id} foi apagado com sucesso!!",
                'success' => $denuncia->delete(),
            ];
        }

        return response()->json($resp);
    }
}
