<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('flashcards', function (Blueprint $table) {
            $table->string('title')->nullable()->after('set_id');
            $table->text('description')->nullable()->after('title');
        });
    }

    public function down()
    {
        Schema::table('flashcards', function (Blueprint $table) {
            $table->dropColumn(['title', 'description']);
        });
    }
};
