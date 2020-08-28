<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockpilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockpiles', function (Blueprint $table) {
            $table->id('stockpile_id');
            $table->uuid('uuid')->nullable();
            $table->string('code', '3')->nullable();
            $table->string('name', '50')->nullable();
            $table->string('address', '100')->nullable();
            $table->tinyInteger('freight_weight_rule')->nullable()->comment('0=lowest 1=send weight 2=netto weight')->default(0);
            $table->tinyInteger('curah_weight_rule')->nullable()->comment('0=lowest 1=send weight 2=netto weight')->default(0);
            $table->decimal('shrink_tolerance_kg', 18, 2)->nullable();
            $table->decimal('shrink_tolerance_persen', 18, 2)->nullable();
            $table->decimal('shrink_claim', 18, 2)->nullable();
            $table->tinyInteger('active')->default(1);
            $table->softDeletes();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('stockpiles');
    }
}
