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
        Schema::create('apicoderassociations', function (Blueprint $table) {
            $table->id('apiCoderAssociationID');
            $table->foreignId('apiFK')->constrained('apis', 'apiID');
            $table->foreignId('languageFK')->constrained('languages', 'languageID');
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
        Schema::dropIfExists('apicoderassociations');
    }
};
