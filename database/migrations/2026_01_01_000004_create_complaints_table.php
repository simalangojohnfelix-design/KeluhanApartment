<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('property_unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('photo')->nullable();
            $table->string('status')->default('pending'); // pending, verified, assigned, in_progress, resolved, rejected
            $table->string('category')->nullable();
            $table->string('urgency')->default('low');    // low, medium, high
            $table->integer('rating')->nullable();
            $table->text('review')->nullable();
            $table->boolean('is_confirmed')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('complaints'); }
};
