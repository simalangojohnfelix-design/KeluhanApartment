<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_unit_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('maintenance_date')->nullable();
            $table->enum('status', ['active', 'maintenance', 'broken', 'retired'])->default('active');
            $table->string('condition')->default('Good'); // Good, Needs Repair, Broken, Replaced
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('assets'); }
};
