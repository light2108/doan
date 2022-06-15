<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers_new', function (Blueprint $table) {
            $table->id();
            $table->string('ten');
            $table->string('email');
            $table->string('password');
            $table->string('dien_thoai');
            $table->string('anh');
            $table->integer('monhoc_id');
            $table->string('lop_id');
            $table->integer('trang_thai');
            $table->integer('quyen');
            $table->date('ngay_sinh');
            $table->string('dia_chi');
            $table->integer('gioi_tinh');
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
        Schema::dropIfExists('teachers_new');
    }
}
