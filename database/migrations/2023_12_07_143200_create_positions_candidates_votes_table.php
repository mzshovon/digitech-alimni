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
        Schema::create('elections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default("annual");
            $table->string('status')->default("paused");
            $table->string('start_date');
            $table->string('end_date');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on(with(new User())->getTable());
            $table->foreign('updated_by')->references('id')->on(with(new User())->getTable());
            $table->timestamps();
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on(with(new User())->getTable());
            $table->foreign('updated_by')->references('id')->on(with(new User())->getTable());
            $table->timestamps();
        });

        // candidates table migration
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('position_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });

        // votes table migration
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('candidate_id')->constrained();
            $table->foreignId('position_id')->constrained();
            $table->integer('retry')->default(0);
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
        Schema::dropIfExists('positions_candidates_votes');
    }
};
