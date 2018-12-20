<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImportData extends Command
{
    /**
     * Nome e asinatura do comando
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * Descrição do comando
     * @var string
     */
    protected $description = 'Carga do Banco de dados';

    /**
     * Criar uma nova instância do commando
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Executar o comando
     *
     * @return mixed
     */
    public function handle()
    {
         
        $files = array_sort(File::files(storage_path('dumps')), function ($file) {
                    return $file->getFilename();
        });
         
        foreach ($files as $file) {
            DB::statement("COPY {$file->getExtension()} FROM '{$file->getPathname()}' DELIMITER '*';");
        }
        
        DB::statement("ALTER SEQUENCE users_id_seq RESTART WITH 2669;");
        DB::statement("ALTER SEQUENCE canais_id_seq RESTART WITH 15;");
        DB::statement("ALTER SEQUENCE tags_id_seq RESTART WITH 13877;");
        DB::statement("ALTER SEQUENCE aplicativos_id_seq RESTART WITH 126;");
        DB::statement("ALTER SEQUENCE conteudos_id_seq RESTART WITH 8670;");
        DB::statement("ALTER SEQUENCE licenses_id_seq RESTART WITH 14;");
        DB::statement("ALTER SEQUENCE categories_id_seq RESTART WITH 69;");
        DB::statement("ALTER SEQUENCE aplicativo_categories_id_seq RESTART WITH 16;");

        /*
        $componentes = explode("\n", file_get_contents(storage_path('dumps/10.componentes')));
        $niveis = explode("\n", file_get_contents(storage_path('dumps/11.niveis')));
        $this->importToOptions($componentes);
        $this->importToOptions($niveis);
        */
    }

    private function importToOptions($meta_data)
    {
        foreach ($meta_data as $key => $value) {
            $data = explode("*", $value);
            DB::statement("insert into options (name, meta_data) values ('{$data[0]}','{$data[1]}')");
        }
    }
}
