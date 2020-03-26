<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable();
            $table->string("url");
            $table->boolean("enabled")->default(1);
            $table->boolean("status")->default(1);
            $table->string("remarks")->nullable();
            $table->unsignedBigInteger("subscriber_id");
            $table->timestamps();
            $table->foreign("subscriber_id")->references("id")->on("subscribers")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
