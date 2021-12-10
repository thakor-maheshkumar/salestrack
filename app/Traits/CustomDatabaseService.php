<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

trait CustomDatabaseService
{
	/**
     * Create dynamic table along with dynamic fields
     *
     * @param       $table_name
     * @param array $fields
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTable($table_name, $fields = [])
    {
        // check if table is not already exists
        if (!Schema::hasTable($table_name)) {
            Schema::create($table_name, function (Blueprint $table) use ($fields, $table_name) {
                $table->increments('id');
                if (count($fields) > 0) {
                    foreach ($fields as $field) {
                        if(isset($field['default']) && !empty($field['default']))
                        {
                            $table->{$field['type']}($field['name'])->default($field['default'])->nullable();
                        }
                        else
                        {
                            $table->{$field['type']}($field['name'])->nullable();
                        }
                    }
                }
                $table->timestamps();
                $table->softDeletes();
            });

            return true;
            //return response()->json(['message' => 'Given table has been successfully created!'], 200);
        }

        //return response()->json(['message' => 'Given table is already existis.'], 400);
        return false;
    }

    /**
     * To delete the tabel from the database 
     * 
     * @param $table_name
     *
     * @return bool
     */
    public function removeTable($table_name)
    {
        Schema::dropIfExists($table_name); 
        
        return true;
    }

    /**
     * Get tabel columns from the database 
     * 
     * @param $table_name
     *
     * @return array $fields
     */
    public function getTableColumns($table)
    {
        //return DB::getSchemaBuilder()->getColumnListing($table);

        // OR

        //return Schema::getColumnListing($table);

        return \DB::select(\DB::raw('SHOW FIELDS FROM '.$table));
    }
}