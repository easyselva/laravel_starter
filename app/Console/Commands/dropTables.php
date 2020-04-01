<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use DB;
use Schema;


class dropTables extends Command
{
    protected $signature = 'droptables';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

      
        foreach(\DB::select('SHOW TABLES') as $table) {
            $table_array = get_object_vars($table);
            \Schema::drop($table_array[key($table_array)]);
        }


    }

}
