<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisitorToUserCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_company', function (Blueprint $table) {
            $table->integer('visitor_id')->unsigned()
                                      ->nullable();

            $table->foreign('visitor_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_company', function (Blueprint $table) {
            $table->dropColumn('visitor_id');
        });
    }
}
