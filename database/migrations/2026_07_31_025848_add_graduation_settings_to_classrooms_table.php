<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('classrooms', function (Blueprint $table) {

            $table->unsignedTinyInteger('minimum_score')
                ->default(75)
                ->after('capacity');

            $table->unsignedTinyInteger('minimum_attendance')
                ->default(80)
                ->after('minimum_score');
        });
    }

    public function down()
    {
        Schema::table('classrooms', function (Blueprint $table) {

            $table->dropColumn([
                'minimum_score',
                'minimum_attendance'
            ]);
        });
    }
};
