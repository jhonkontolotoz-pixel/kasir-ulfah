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
        Schema::create('orders', function (Blueprint $table) {
            $table->ulid();
            $table->string('code')->unique();
            $table->enum("status",['shipped','delivered','pending','canceled'])->default('pending');
            $table->decimal("total_price",unsigned:true);
            $table->enum('payment_method',['cash','card'])->default('card');
            $table->foreignId("user_id")->constrained("users")->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("customer_id")->constrained("customers")->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('orders');
    }
};
