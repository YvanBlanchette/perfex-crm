<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('number')->unique();
            $table->string('portal_token')->nullable()->unique();
            $table->enum('status',['draft','unpaid','paid','overdue','partial','cancelled'])->default('draft');
            $table->date('date');
            $table->date('due_date');
            $table->decimal('subtotal',15,2)->default(0);
            $table->decimal('discount',15,2)->default(0);
            $table->enum('discount_type',['percent','fixed'])->default('percent');
            $table->decimal('tax',5,2)->default(0);
            $table->decimal('total',15,2)->default(0);
            $table->string('currency',3)->default('USD');
            $table->text('terms')->nullable();
            $table->text('client_note')->nullable();
            $table->timestamps();
        });
        Schema::create('invoice_items', function(Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->text('long_description')->nullable();
            $table->decimal('qty',10,2)->default(1);
            $table->decimal('rate',15,2)->default(0);
            $table->string('unit')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('invoice_items'); Schema::dropIfExists('invoices'); }
};