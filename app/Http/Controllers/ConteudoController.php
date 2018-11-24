<?php

namespace App\Http\Controllers;

use App\Conteudo;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ConteudoFormRequest;
use Illuminate\Support\Facades\Validator;

class ConteudoController extends Controller
{
    public function __construct(Conteudo $conteudo, Request $request)
    {
        $this->middleware('jwt.verify')->except(['list','search','getById','getByTagId','getSitesTematicos']);
        $this->conteudo = $conteudo;
        $this->request = $request;
    }
    /**
     * Lista de conteúdos.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $limit = $this->request->query('limit', 15);
        $orderBy = ($this->request->has('order')) ? $this->request->query('order') : 'created_at';
        $page = ($this->request->has('page')) ? $this->request->query('page') : 1;
        $isCanal = $this->request->query('canal');
       
        $query = $this->conteudo::query();
        $query->when($isCanal, function ($q, $canal) {
            return $q->where('canal_id', $canal)
                    ->where('is_approved', 'true');
        });

        $conteudos = $query->orderBy($orderBy, 'desc')
                        ->paginate($limit)
                        ->setPath("/conteudos?limit={$limit}&canal=$isCanal");
        
        return response()->json([
            'success'=> true,
            'title'=> 'Mídias educacionais',
            'paginator'=> $conteudos
        ], 200);
    }
    public function getSitesTematicos()
    {
        $limit = $this->request->query('limit', 15);
        $orderBy = $this->request->query('order', 'created_at');
        
        $sitesTematicos = $this->conteudo::where('is_site', 'true')
                        ->where('is_approved', 'true')
                        ->orderBy($orderBy, 'desc')
                        ->paginate($limit)
                        ->setPath("/sites-tematicos?limit={$limit}");
        
        return response()->json([
            'success'=> true,
            'title'=> 'Sites Temáticos',
            'paginator'=> $sitesTematicos
        ], 200);
    }
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
     * Atualiza o conteudo.
     *
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $conteudo = $this->conteudo::find($id);

        $conteudo->update([
            'canal_id' => $this->request->get('canal_id'),
            'title' => $this->request->get('title'),
            'description' => $this->request->get('description'),
            'authors' => $this->request->get('authors'),
            'source' => $this->request->get('source'),
            'license_id' => $this->request->get('license_id'),
            'is_featured' => $this->request->get('is_featured'),
            'is_approved' => $this->request->get('is_approved'),
            'is_site' => $this->request->get('is_site'),
            'options' => json_decode($this->request->get('options'), true)
        ]);

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
     * Apaga o aplicativo do banco de dados.
     *
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response\Json
     */
    public function delete($id)
    {
        $conteudo = $this->conteudo::find($id);
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
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function search($termo)
    {
        $limit = $this->request->query('limit', 15);
        $page = $this->request->query('page', 1);

        $conteudos = DB::table(DB::raw("conteudos as cd, plainto_tsquery('simple', lower(unaccent('${termo}'))) query"))
                        ->select(['cd.id','cd.title',
                                DB::raw('ts_rank_cd(cd.ts_documento, query) AS ranking')
                                ])
                        ->whereRaw('query @@ cd.ts_documento')
                        ->where('cd.is_approved', '=', 'true')
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
     * @param id $id do conteúdo digital
     * @return \Illuminate\Http\Response
     */
    public function getById($id)
    {
        
        $conteudo = $this->conteudo::with(['user','canal','tags'])->find($id);

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

    public function getByTagId($id)
    {
        $limit = $this->request->query('limit', 15);

        $conteudos = $this->conteudo
        ->whereRaw("? = ANY(SELECT (CAST(jsonb_array_elements(options->'tags')->>'id' AS INT)))")
        ->setBindings([$id])
        ->paginate(15);

        $conteudos->setPath("/conteudos/tag/{$id}?limit={$limit}");

        DB::table('tags')->where('id', $id)->increment('searched', 1);
        
        $tag = Tag::select('name', 'searched')->find($id);

        return response()->json([
            'success' => true,
            'tag' => $tag,
            'paginator' => $conteudos
        ]);
    }
}
