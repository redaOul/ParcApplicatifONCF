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
        Schema::create('apps', function (Blueprint $table) {
            $table->id('appID')->autoIncrement();
            $table->string('appCode');
            $table->string('appName');
            $table->string('version');
            $table->text('description');
            $table->string('status');

            $table->string('solutionType');
            $table->string('architectureType');
            $table->string('applicationType');

            $table->string('platform');
            $table->string('dataBase');
            $table->string('middleware');

            $table->string('appExe');
            $table->string('documentation');
            $table->string('sourceCode');
            $table->string('appIcon')->default('/Logos/AppLogos/defaultImgApp.png');

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
        Schema::dropIfExists('apps');
    }
};
