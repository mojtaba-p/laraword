<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->string('slug')->index();
            $table->text('content');
            $table->string('thumbnail')->nullable();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('likes_count')->default(0);
            $table->tinyInteger('views_count')->default(0);
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamp('pinned_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
