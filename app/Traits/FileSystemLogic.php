<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileSystemLogic
{
    /**
     * Retorna imagem de destaque do nivel de ensino
     *
     * @param $components array de componentes curriculares
     *
     * @return string
     */
    public static function getEmitecImage($components)
    {
        $arrComp = $components->get()->pluck('id')->toArray();

        $disciplina = DB::table('curricular_components as cc')
            ->select(["cc.id"])
            ->join('niveis_ensino as ne', 'ne.id', '=', 'cc.nivel_id')
            ->whereIn('cc.id', $arrComp)
            ->get()
            ->first();
        if (!$disciplina) {
            return Storage::disk('public-path')->url("img/fundo-padrao.svg");
        }

        $image = "/imagem-associada/emitec/img-emitec_disciplina{$disciplina->id}.png";
        $exist = self::windowsDirectory(Storage::disk('conteudos-digitais')->exists($image));

        return ($exist) ? Storage::disk('conteudos-digitais')->url($image) : null;
    }
    public static function getCategoryImage($category_id)
    {
        $path_category = self::windowsDirectory(
            Storage::disk('conteudos-digitais')->path("imagem-associada/categoria/{$category_id}.*")
        );
        
        $file = self::windowsDirectory(collect(File::glob($path_category))->first());
        $filename = basename($file);
        
        return $filename ? Storage::disk('conteudos-digitais')
            ->url("imagem-associada/categoria/{$filename}") : null;
    }
    /**
     * Retorna imagem de destaque
     *
     * @param $tipo tipo de conteúdo
     * @param $id id do conteúdo
     *
     * @return Storage
     */
    public static function getImageFromTipo($tipo, $id)
    {
        $path_assoc = self::windowsDirectory(
            Storage::disk('conteudos-digitais')->path('imagem-associada')
        );

        $file = self::findFiles($path_assoc, $id, $tipo);
        
        if ($file) {
            $replace = Storage::disk('conteudos-digitais')->url("imagem-associada/{$file}");
            return str_replace('//sinopse', '/sinopse', $replace);
        }

        return Storage::disk('public-path')->url("img/fundo-padrao.svg");
    }
    /**
     * Procura no diretorio os arquivos de imagem associada ou sinopse
     *
     * @param $path     diretorio
     * @param $filename nome do arquivo a ser encontrado
     * @param $tipo     id do tipo de conteúdo
     *
     * @return string
     */
    public static function findFiles($path, $id, $tipo)
    {
        $path_img_assoc = self::windowsDirectory("{$path}/$id.*");
        $file = collect(File::glob($path_img_assoc))->first();

        if ($tipo == 5 && !$file) {
            $path_sinopse = self::windowsDirectory("{$path}/sinopse/{$id}.*.*");
            $file = collect(File::glob($path_sinopse))->shuffle()->first();
        }


        return Str::replaceFirst($path . '/', '', $file);
    }
    /**
     * Seleciona os metadados do arquivo
     *
     * @param $directory diretorio a procurar
     * @param $id        id do conteudo
     *
     * @return array
     */
    public function getMetaDados($directory, $id)
    {
        $filesystem = new Filesystem;

        $path = self::windowsDirectory(
            Storage::disk('conteudos-digitais')->path($directory) . "/{$id}.*"
        );

        $files = $filesystem->glob($path);
        $arr = [];
        foreach ($files as $file) {
            $name = $filesystem->name($file) . "." . $filesystem->extension($file);
            $arr = [
                'mime_type' => $filesystem->mimeType($file),
                'extension' => $filesystem->extension($file),
                'size'      => $filesystem->size($file),
                'name'      => $name,
                'url'       => Storage::disk('conteudos-digitais')->url($directory) . "/{$name}"
            ];
        }
        return (object) $arr;
    }
    /**
     * Retorna galeria de imagens
     *
     * @param $rand seleciona se ordena de forma randomica as imagens
     *
     * @return array de imagens
     */
    public function getImagesGallery($rand = false)
    {
        $path = $this->storage::disk('galeria');
        $path = self::windowsDirectory(
            $path->getDriver()->getAdapter()->getPathPrefix()
        );
        $files = File::allFiles($path);

        if (!$rand) {
            return collect($files)->map(function ($file) {
                return Storage::disk('galeria')->url("{$file->getFilename()}");
            });
        }

        return collect($files)->map(function ($file) {
            return Storage::disk('galeria')->url("{$file->getFilename()}");
        })->shuffle();
    }
    /**
     * Salva arquivo pasta de downloads
     *
     * @param $id integer
     * @param $file laravel request
     *
     * @return File
     */
    public function createFile($id, $file)
    {
        if ($file) {
            $filesystem = new Filesystem;
            $path = Storage::disk('conteudos-digitais')->path("download") . "/{$id}.*";
            $files = $filesystem->glob($path);
            File::delete($files);
            $name = "{$id}.{$file->guessExtension()}";

            $file->storeAs('download', $name, 'conteudos-digitais');
            return $file;
        }
    }

    /**
     * Remplaza diretorio de windows C:\\pasta\pasta-filha por C:/pasta/pasta-filha
     *
     * @param $path diretorio
     *
     * @return string
     */
    public static function windowsDirectory($path)
    {
        if (env('APP_SO', 'linux') == 'windows') {
            return str_replace('\\', '/', $path);
        }

        return $path;
    }


    /**
     * Armazena arquivo pasta de guias-pedagogicos ou download ou imagem-associada
     *
     * @param $id integer
     * @param $file laravel request
     *
     * @return File
     */
    public function saveFile($id, $files, $local = null)
    {
        if ($files) {
            foreach ($files as $file) {
                $filesystem = new Filesystem;
                $rand = rand(5, 99999);
                $path = Storage::disk('conteudos-digitais')->path($local) . "/{$id}.*";
                $files = $filesystem->glob($path);
                $name = "{$id}.{$rand}.{$file->guessExtension()}";

                $file->storeAs($local, $name, 'conteudos-digitais');
            }
            return $file;
        }
    }

    /**
     * Retorna tipos de extessões 
     *
     */
    public function mimeTypes()
    {

        $mimes = "ppt,pps,odp,link,pdf,epub,doc,docx,odt,swf,exe,zip,rar,swf,wmv,mpg,flv,avi,
        youtube,mp4,mp3,webm,xls,xml,ods,csv,jpg,jpeg,png,gif,txt";
        
        return $mimes;
    }
}
