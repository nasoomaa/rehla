<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('core_config', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('locale_code')->default('*');
            $table->boolean('is_secret')->default(false);
            $table->timestamps();

            $table->unique(['key', 'locale_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('core_config');
    }
};
