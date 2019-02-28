<?php

namespace App\Http\Controllers;

use App\Conteudo;
use App\Tag;
use App\Helpers\UrlValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;

class ConteudoController extends Controller
{
    public function __construct(Conteudo $conteudo, Request $request)
    {
        $this->middleware('jwt.verify')->except(['list','search','getById','getByTagId','getSitesTematicos']);
        $this->conteudo = $conteudo;
        $this->request = $request;
    }
    /**
     * Lista de conteúdos por canal
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $limit = $this->request->query('limit', 15);
        $orderBy = ($this->request->has('order')) ? $this->request->query('order') : 'created_at';
        $page = ($this->request->has('page')) ? $this->request->query('page') : 1;
        $canal = $this->request->query('canal');
        
        $tipos = $this->request->get('tipos');
        $licencas = $this->request->query('licencas');
        $componentes = $this->request->query('componentes');
        $categorias =  $this->request->query('categorias');
        return response()->json([
                'tipos' => $tipos,
                'componentes'=> $componentes,
                'licencas' => $licencas,
                'categorias' => $categorias
            ]);
        $query = $this->conteudo::query();
        $query->when($canal, function ($q, $canal) {
            return $q->where('canal_id', $canal)
                    ->where('is_approved', 'true');
        });
        
        $query->when($tipos, function ($q, $tipos) {
            return $q->whereIn('options->tipo->id', explode(',', $tipos));
        });
        $url = "limit={$limit}&canal={$canal}";
        $url .= "&tipos={$tipos}&componentes={$componentes}&categorias={$categorias}&licencas={$licencas}";

        $conteudos = $query->with('canal')
                        ->orderBy($orderBy, 'desc')
                        ->paginate($limit)
                        ->setPath("/conteudos?{$url}");
        
        return response()->json([
            'success'=> true,
            'title'=> 'Mídias educacionais',
            'paginator'=> $conteudos
        ], 200);
    }
    /**
     * Lista de sites temáticos
     *
     * @return \Illuminate\Http\Response
     */
    public function getSitesTematicos()
    {
        $limit = $this->request->query('limit', 15);
        $orderBy = $this->request->query('order', 'created_at');
        
        $sitesTematicos = $this->conteudo::with('canal')
                        ->where('is_site', 'true')
                        ->where('is_approved', 'true')
                        ->orderBy($orderBy, 'desc')
                        ->paginate($limit)
                        ->setPath("/conteudos/sites?limit={$limit}");
        
        return response()->json([
            'success'=> true,
            'title'=> 'Sites Temáticos',
            'paginator'=> $sitesTematicos
        ], 200);
    }
    /**
     * Valida a criação do conteúdo
     *
     * @return
     */
    private function validar()
    {
        $validator = Validator::make($this->request->all(), [
            'title' => 'required|min:10|max:255',
            'description' => 'required|min:140',
            'tipo' => 'required',
            'authors' => 'required',
            'source' => 'required',
            'license' => 'required',
            'terms' => 'required|in:true,false',
            'is_approved' => 'required|in:true,false'
        ]);

        return $validator;
    }


    /**
     * Adiciona e valida um novo conteúdo.
     *
     * @return Json
     */
    public function create()
    {
        $validator = $this->validar($this->request);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível efetuar o cadastro',
                'errors' => $validator->errors()
            ], 200);
        }

        $conteudo = $this->conteudo;

        $conteudo->user_id = Auth::user()->id;
        $conteudo->approving_user_id = Auth::user()->id;
        $conteudo->canal_id = $this->request->get('canal_id', '');
        $conteudo->title = $this->request->get('title');
        $conteudo->description = $this->request->get('description');
        $conteudo->authors = $this->request->get('authors');
        $conteudo->source = $this->request->get('source');
        $conteudo->license_id = $this->request->get('license_id');
        $conteudo->is_featured = $this->request->get('is_featured');
        $conteudo->is_approved = $this->request->get('is_approved');
        $conteudo->is_site = $this->request->get('is_site');
        $conteudo->options = json_decode($this->request->get('options'), true);

        $conteudo->save();

        return response()->json([
            'success' => true,
            'message' => 'Conteúdo cadastrado com sucesso',
            'id' => $conteudo->id
        ]);
    }

    /**
     * Atualiza o conteúdo.
     *
     * @param  Integer $id
     * @return Json
     */
    public function update($id)
    {
        dd($id);
        $conteudo = $this->conteudo::find($id);
        $conteudo->fill($this->request->all());

        $conteudo->save();

        return response()->json([
            'success' => true,
            'data' => $conteudo
        ]);
    }
    public function createConteudoTags($id)
    {
        $conteudo = $this->conteudo::find($id);
        $conteudo->tags()->attach($this->request->get('tags'));
    }
    /**
     * Apaga o conteúdo do banco de dados.
     *
     * @param  Integer $id
     * @return Json
     */
    public function delete($id)
    {
        $conteudo = $this->conteudo::with('tags')->find($id);
        $conteudo->tags()->detach();
        $conteudo->componentes()->detach();
        $conteudo->niveis()->detach();

        $resp = [];
        if (!$conteudo) {
            $resp = [
                'menssage' => 'Não foi Possível deletar o conteúdo',
                'success' => false
            ];
        } else {
            $resp = [
                'menssage' => "Conteúdo de id: {$id} foi apagado com sucesso!!",
                'success' => $conteudo->delete()
            ];
        }

        return response()->json($resp);
    }
    /**
     * Procura conteudos por full text search.
     *
     * @param  String $termo
     * @return Json
     */
    public function search($termo)
    {
        $limit = $this->request->query('limit', 15);
        $page = $this->request->query('page', 1);

        $conteudos = DB::table(DB::raw("conteudos as cd, plainto_tsquery('simple', lower(unaccent(?))) query"))
                        ->select(['cd.id','cd.title',
                                DB::raw('ts_rank_cd(cd.ts_documento, query) AS ranking')
                                ])
                        ->whereRaw('query @@ cd.ts_documento')
                        ->whereRaw('cd.is_approved = true')
                        ->setBindings([$termo])
                        ->orderBy('ranking', 'desc')
                        ->paginate($limit);


        $conteudos->setPath("/conteudos/search/{$termo}?limit={$limit}");

        return response()->json([
            'success'=> true,
            'message' => 'Resultados da busca',
            'paginator' => $conteudos,
            'has_more_pages' => $conteudos->hasMorePages(),
            'pages'=> $conteudos->count(),
            'page'=> $conteudos->currentPage(),
            'limit' => $conteudos->perPage()
        ]);
    }
    /**
     * Procura um conteúdo por id
     *
     * @param Integer $id
     * @return Json
     */
    public function getById($id)
    {

        $conteudo = $this->conteudo::with([
            'user','canal','tags','license', 'componentes', 'niveis'
            ])->find($id);

        if ($conteudo) {
            return response()->json([
                'success' => true,
                'conteudo' => $conteudo
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Conteudo não encontrado'
            ]);
        }
    }
    public function teste()
    {
        $conteudo = Conteudo::find(4);
        //$conteudo->tags()->detach([1,5]);
        
        
        return response()->json([
            'tags' => $conteudo->tags
        ]);
    }
    /**
     * Lista de Conteúdos por Tag ID
     *
     * @param Integer $id
     * @return Json
     */
    public function getByTagId($id)
    {
        $limit = $this->request->query('limit', 15);
        
        $conteudos = $this->conteudo::select(['id','title'])->whereHas('tags', function ($query) use ($id) {
            $query->where('id', '=', $id);
        })->paginate($limit);
        

        $conteudos->setPath("/conteudos/tag/{$id}?limit={$limit}");

        DB::table('tags')->where('id', $id)->increment('searched', 1);
        
        return response()->json([
            'success' => true,
            'paginator' => $conteudos
        ]);
    }
}
