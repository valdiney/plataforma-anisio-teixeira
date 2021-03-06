<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Conteudo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\TransformDate;
use App\Tag;
use App\AplicativoCategory;
use App\Traits\UserCan;

class Aplicativo extends Conteudo
{
    use SoftDeletes, UserCan;

    const CANAL_ID = 9;
    const QT_ACCESS_INIT = 0;

    protected $table = 'aplicativos';

    protected $fillable = [
        'name',
        'user_id',
        'canal_id',
        'category_id',
        'description',
        'url',
        'is_featured',
        'options'
    ];
    protected $appends = [
        'image',
        'excerpt',
        'url_exibir',
        'formated_date',
        'user_can'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $casts = [
        'options' => 'array',
    ];

    public function canal()
    {
        Canal::$without_appends = true;

        return $this->belongsTo(Canal::class, 'canal_id')
            ->select(['id', 'name', 'slug', 'options->color as color'])
            ->where('id', 9);
    }
    /**
     * Conjunto de tags do aplicativo
     *
     * @return void
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'aplicativo_tag', 'aplicativo_id', 'tag_id')
            ->select(['id', 'name'])->orderBy('name');
    }
    /**
     * Conjunto de categorias do aplicativo
     *
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(AplicativoCategory::class, 'category_id', 'id');
    }

    /**
     * Descrição abreviada
     *
     * @return void
     */
    public function getExcerptAttribute()
    {
        return strip_tags(Str::words($this['description'], 30));
    }
    /**
     * Imagem de destaque do aplicativo
     *
     * @return void
     */
    public function getImageAttribute()
    {
        $image = "{$this['id']}.jpg";
        return Storage::disk('aplicativos-educacionais')
            ->url("imagem-associada/{$image}");
    }
    /**
     * Cria url exibir
     *
     * @return void
     */
    public function getUrlExibirAttribute()
    {
        $slug = $this->canal()->pluck('slug')->first();

        return "/{$slug}/aplicativo/exibir/" . $this['id'];
    }
    /**
     * Seleciona e tranforma created-at ao formato (06 setembro de 2019 ás 17:37)
     *
     * @return void
     */
    public function getFormatedDateAttribute()
    {
        return TransformDate::format($this['created_at']);
    }
}
