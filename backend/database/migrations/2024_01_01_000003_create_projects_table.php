<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('status',['not_started','in_progress','on_hold','cancelled','finished'])->default('not_started');
            $table->enum('priority',['low','medium','high','urgent'])->default('medium');
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();
            $table->decimal('budget',15,2)->nullable();
            $table->enum('billing_type',['not_billable','fixed_cost','project_hours','task_hours'])->default('not_billable');
            $table->decimal('rate_per_hour',8,2)->nullable();
            $table->decimal('estimated_hours',8,2)->nullable();
            $table->unsignedTinyInteger('progress')->default(0);
            $table->timestamps();
        });
        Schema::create('project_members', function(Blueprint $table) {
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->primary(['project_id','user_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('project_members'); Schema::dropIfExists('projects'); }
};