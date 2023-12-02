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
        Schema::create('news_letters', function (Blueprint $table) {
            $table->id();
            $table->string("template_name",455)->nullable();
            $table->longText("news");
            $table->string("bulk_id", 455);
            $table->string("start_date")->nullable();
            $table->string("end_date")->nullable();
            $table->string("starts_at")->nullable();
            $table->string("ends_at")->nullable();
            $table->string("status")->default('processing');
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
        Schema::dropIfExists('news_letters');
    }
};
