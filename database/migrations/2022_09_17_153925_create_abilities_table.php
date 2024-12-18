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
        Schema::create('abilities', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("label")->nullable();
            $table->timestamps();
        });

        Schema::create('ability_role', function (Blueprint $table) {
            $table->foreignId("role_id")->constrained("roles")->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("ability_id")->constrained("abilities")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
        Schema::create('user_ability', function (Blueprint $table) {
            $table->foreignId("user_id")->constrained("users")->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("ability_id")->constrained("abilities")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     **/

    public function down()
    {
        Schema::table('abilities', function (Blueprint $table) {
            //
        });
    }
};
