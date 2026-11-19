<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->unsignedTinyInteger('installment_count')->nullable()->after('installment_info');
            $table->boolean('installment_is_interest_free')->default(false)->after('installment_count');
        });
    }

    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['installment_count', 'installment_is_interest_free']);
        });
    }
};
