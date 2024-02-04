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
        Schema::create('apis', function (Blueprint $table) {
            $table->id('apiID')->autoIncrement();
            $table->string('apiCode');
            $table->string('apiName');
            $table->string('version');
            $table->text('description');
            $table->string('status');
            $table->string('secutity');

            $table->string('apiType');
            $table->string('apiResponse');

            $table->string('dataBase');
            $table->string('middleware');

            $table->string('documentation');
            $table->string('sourceCode');
            $table->string('apiIcon')->default('/Logos/ApiLogos/defaultImgApi.png');

            $table->string('department');
            $table->string('service');
            $table->string('editor');
            $table->foreignId('employeeFK')->constrained('employees', 'employeeID');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apis');
    }
};
