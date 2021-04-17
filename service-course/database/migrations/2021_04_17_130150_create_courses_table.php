<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('certificate');
            $table->string('thumbnail')->nullable();
            $table->enum('type', ['free', 'premium']);
            $table->enum('status', ['draf', 'publish']);
            $table->integer('price')->nullable()->default(0);
            $table->enum('level', ['all-level', 'beginner', 'intermediet', 'advance']);
            $table->longText('description')->nullable();
            $table->foreignId('mentor_id')->constrained('mentors')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
