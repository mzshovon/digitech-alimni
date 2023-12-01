<?php

use App\Models\User;
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
        Schema::create('membership_details', function (Blueprint $table) {
            $table->id();
            $table->string("first_name")->nullable(false);
            $table->string("last_name")->nullable(false);
            $table->string("nid")->nullable(false);
            $table->string("membership_id")->nullable();
            $table->string("dob")->nullable(false);
            $table->string("address")->nullable();
            $table->string("blood_group")->nullable();
            $table->string("batch")->nullable(false);
            $table->string("employeer_name")->nullable();
            $table->string("employeer_address")->nullable();
            $table->string("designation")->nullable();
            $table->string("reference")->nullable();
            $table->string("reference_number")->nullable();
            $table->foreignIdFor(User::class)->constrained()->restrictOnDelete();
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
        Schema::dropIfExists('membership_details');
    }
};
