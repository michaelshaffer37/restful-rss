<?php

use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConfigureEntryCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Define the Indexes on the entry collection.
         */
        Schema::create('entries', function (Blueprint $collection) {
            $collection->unique('link');

            $collection->index(
                ['name' => 'text', 'description' => 'text'],
                null,
                null,
                ['default_language' => 'english']
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('entries');
    }
}
