<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string("company_name")->nullable();
            $table->string("country")->nullable();
            $table->unsignedBigInteger("package_id");
            $table->unsignedBigInteger("user_id");
            $table->date("subscribed_at");
            $table->date("expire_at");
            $table->boolean("status")->default(1);
            $table->boolean("enableSms")->default(0);
            $table->text("smsApi")->nullable();
            $table->string("senderId")->nullable();
            $table->string("number")->nullable();
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("package_id")->references("id")->on("packages")->onDelete("cascade");
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribers');
    }
}
