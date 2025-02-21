<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('flashcards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('set_id')->constrained()->onDelete('cascade'); // Thuộc bộ thẻ nào
            $table->string('term'); // Câu hỏi hoặc từ vựng
            $table->text('definition'); // Định nghĩa hoặc câu trả lời
            $table->string('image')->nullable(); // Ảnh minh họa (nếu có)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('flashcards');
    }
};
