<?php

namespace App\Helpers;

use App\NivelEnsino;
use App\CurricularComponentCategory;
use App\License;
use App\Tipo;
use App\User;
use App\Options;
use Illuminate\Support\Facades\DB;

class SideBar
{

    public static function getSideBarAdvancedFilter()
    {
        $componentes = CurricularComponentCategory::with(['componentes' => function ($q) {
            $q->orderBy('name');
        }])->get();

        $licencas = License::select(['id', 'name'])->whereRaw('parent_id is null')->get();
        $niveis = NivelEnsino::with(['componentes' => function ($q) {
            $q->where('curricular_components.id', '!=', 13)
                ->where('curricular_components.id', '!=', 12)
                ->where('curricular_components.id', '!=', 31)
                ->orderBy('name');
        }])->get();
        $layout = (object) Options::select("meta_data")->where("name", "like", "layout")->get()->first();
        $canais =  DB::select(DB::raw("SELECT name,
                                    slug,
                                    options->'order_menu' AS order,
                                    options->'back_url_exibir' AS url_exibir
                                    FROM canais
                                    WHERE is_active = ?
                                    ORDER BY options->'order_menu';"), [true]);
        
        $destaques = new Destaques();
        $destaques = $destaques->getHomeDestaques('conteudos-recentes');

        return [
            'layout' => $layout,
            'links' => $canais,
            'licencas' => $licencas,
            'destaques' => $destaques,
            'componentes' => $componentes,
            'niveis' => $niveis,
            'tipos' => Tipo::select(['id', 'name'])->orderBy('name')->get()
        ];
    }
    /**
     * Cria o menu de administração
     *
     * @param User $user
     * @return void
     */
    public function getAdminSidebar(User $user)
    {
        $links = $this->getlinks();

        return $links->map(function ($link) use ($user) {
            if ($user->can($link['hability'], $link['class'])) {
                return $this->createMenu($link['label'], $link['slug']);
            }
        });
    }
    /**
     * Cria json para Links de administração
     *
     * @param [type] $label
     * @param [type] $slug
     * @param string $name
     * @param string $view
     * @param string $action
     * @return void
     */
    public function createMenu($label, $slug, $name = '', $view = 'admin', $action = 'listar')
    {

        return [
            "label" => $label,
            "name" => $name ? $name : $slug,
            "view" => $view,
            "params" => ["slug" => $slug, "action" => $action]
        ];
    }
    /**
     * Configurações de links
     *
     * @return void
     */
    public function getlinks()
    {
        return collect([
            [
                'label' => 'Aplicativos',
                'slug' => 'aplicativos',
                'hability' => 'index',
                'class' => \App\Aplicativo::class
            ],
            [
                'label' => 'Conteudos',
                'slug' => 'conteudos',
                'hability' => 'index',
                'class' => \App\Conteudo::class
            ],
            [
                'label' => 'Canais',
                'slug' => 'canais',
                'hability' => 'index',
                'class' => \App\Canal::class
            ],
            [
                'label' => 'Fale Conosco',
                'slug' => 'contato',
                'hability' => 'index',
                'class' => \App\Contato::class
            ],
            [
                'label' => 'Licenças',
                'slug' => 'licencas',
                'hability' => 'index',
                'class' => \App\License::class
            ],
            [
                'label' => 'Tipo de Usuário',
                'slug' => 'roles',
                'hability' => 'index',
                'class' => \App\Role::class
            ],
            [
                'label' => 'Palavras Chaves',
                'slug' => 'tags',
                'hability' => 'index',
                'class' => \App\Tag::class
            ],
            [
                'label' => 'Tipos de Conteúdos',
                'slug' => 'tipos',
                'hability' => 'index',
                'class' => \App\Tipo::class
            ],
            [
                'label' => 'Usuários',
                'slug' => 'usuarios',
                'hability' => 'index',
                'class' => \App\User::class
            ],
            [
                'label' => 'Categorias',
                'slug' => 'categorias',
                'hability' => 'index',
                'class' => \App\Category::class
            ]

        ]);
    }
}
