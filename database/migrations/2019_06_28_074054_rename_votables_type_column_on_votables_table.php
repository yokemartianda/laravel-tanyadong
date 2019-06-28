<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameVotablesTypeColumnOnVotablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('votables', function (Blueprint $table) {
            $table->renameColumn('votable_type', 'votables_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('votables', function (Blueprint $table) {
            $table->renameColumn('votables_type', 'votable_type');
        });
    }
}
