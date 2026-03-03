<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('company')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->enum('status',['new','contacted','in_progress','proposal_sent','won','lost','converted'])->default('new');
            $table->string('source')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('value',15,2)->nullable();
            $table->text('description')->nullable();
            $table->foreignId('converted_to_client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->timestamps();
        });
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('number')->unique();
            $table->string('portal_token')->nullable()->unique();
            $table->enum('status',['draft','sent','accepted','declined','expired'])->default('draft');
            $table->date('date');
            $table->date('expiry_date')->nullable();
            $table->decimal('subtotal',15,2)->default(0);
            $table->decimal('discount',15,2)->default(0);
            $table->enum('discount_type',['percent','fixed'])->default('percent');
            $table->decimal('tax',5,2)->default(0);
            $table->decimal('total',15,2)->default(0);
            $table->string('currency',3)->default('USD');
            $table->text('terms')->nullable();
            $table->timestamps();
        });
        Schema::create('estimate_items', function(Blueprint $table) {
            $table->id();
            $table->foreignId('estimate_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->decimal('qty',10,2)->default(1);
            $table->decimal('rate',15,2)->default(0);
            $table->string('unit')->nullable();
            $table->timestamps();
        });
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category');
            $table->string('name');
            $table->decimal('amount',15,2);
            $table->date('date');
            $table->string('currency',3)->default('USD');
            $table->boolean('billable')->default(false);
            $table->text('note')->nullable();
            $table->timestamps();
        });
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('title')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('estimate_items');
        Schema::dropIfExists('estimates');
        Schema::dropIfExists('leads');
    }
};