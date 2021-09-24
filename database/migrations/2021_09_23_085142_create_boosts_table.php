<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boosts', function (Blueprint $table) {
            $table->id();
            $table->string('requester_name');
            $table->string('company_name');
            $table->string('group');
            $table->decimal('budget');
            $table->string('program_name');
            $table->string('target_url');
            $table->date('boost_start');
            $table->date('boost_end')->nullable();
            $table->string('detail')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('boosts');
    }
}
