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
        Schema::create('sales', function (Blueprint $table) {
            $table->id()->from(1_000_000_000);
            $table->string('code', 32)->nullable()->unique();
            $table->foreignId('seller_id')->constrained('sellers');
            $table->unsignedBigInteger('amount');
            $table->decimal('commission_rate', 6, 3);
            $table->unsignedBigInteger('commission_amount');
            $table->date('sale_at');
            $table->datetimes();

            $table->index(['amount', 'commission_amount', 'sale_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
