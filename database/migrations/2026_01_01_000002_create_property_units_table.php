<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('property_units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_number')->unique();
            $table->string('type')->default('Hunian');
            $table->string('floor')->nullable();
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('lease_start')->nullable();
            $table->date('lease_end')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('property_units'); }
};
