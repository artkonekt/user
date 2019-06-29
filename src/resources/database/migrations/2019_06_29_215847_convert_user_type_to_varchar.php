<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertUserTypeToVarchar extends Migration
{
    public function up()
    {
        $typeFieldName = $this->escape('type');

        Schema::table('users', function (Blueprint $table) {
            $table->string('type_new')->after('type')->default('client');
        });

        DB::update("UPDATE users set type_new = $typeFieldName");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('type')->after('type_new')->default('client');
        });

        DB::update("UPDATE users set $typeFieldName = type_new");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('type_new');
        });
    }

    public function down()
    {
        $typeFieldName = $this->escape('type');

        Schema::table('users', function (Blueprint $table) {
            $table->string('type_new')->after('type')->default('client');
        });

        DB::update("update users set type_new = $typeFieldName");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('type', ['client', 'admin'])->default('client');
        });

        DB::update("update users set $typeFieldName = type_new");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('type_new');
        });
    }

    private function escape(string $word): string
    {
        return DB::table('users')->getGrammar()->wrap($word);
    }
}
