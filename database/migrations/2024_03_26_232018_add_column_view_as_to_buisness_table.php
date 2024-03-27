<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnViewAsToBuisnessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buisness', function (Blueprint $table) {
            $table->string('view_as')->nullable()->after('buisness_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buisness', function (Blueprint $table) {
            $table->dropColumn('view_as');
        });
    }
}
