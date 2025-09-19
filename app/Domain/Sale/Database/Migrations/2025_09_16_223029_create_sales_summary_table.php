<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_summary', function (Blueprint $table) {
            $table->id()->from(1_000_000_000);
            $table->string('code', 32)->nullable()->unique();
            $table->foreignId('seller_id')->constrained('sellers');
            $table->unsignedInteger('total_sales_count')
                ->comment('quantidade de vendas realizadas no dia');
            $table->unsignedBigInteger('total_sales_amount')
                ->comment('valor total das vendas realizadas no dia');
            $table->unsignedBigInteger('total_commission_amount')
                ->comment('valor total das comissões das vendas realizadas no dia');
            $table->date('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_summary');
    }
};
