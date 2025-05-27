<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->unsignedDouble('price');
        });
    }

    public function down()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->string('status')->default('available');
            $table->dropColumn('price');
            $table->dropColumn('equipment_type_id');
        });
    }
};

