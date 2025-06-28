<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('reference');
            $table->string('status')->default('PENDING');
            $table->string('currency')->default('XAF');
            $table->string('operator')->nullable();
            $table->string('code')->nullable();
            $table->float('amount')->default(0);
            $table->float('app_amount')->default(0);
            $table->string('external_user')->nullable();
            $table->string('signature')->nullable();
            $table->string('operator_reference')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('endpoint')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
