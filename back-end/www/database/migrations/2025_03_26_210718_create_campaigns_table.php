<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->decimal('budget', 10, 2);
            $table->string('description', 40);
            $table->date('begin_date');
            $table->date('end_date');
            $table->timestamps();
            $table->index(['begin_date', 'end_date']);
        });
        
        // o mysql 8 nao aceita mais decimal unsined (definido como deprecated)
        // visite: https://dev.mysql.com/doc/refman/8.4/en/numeric-type-syntax.html#:~:text=The%20UNSIGNED%20attribute%20is%20deprecated,constraint%20instead%20for%20such%20columns.
        DB::statement('ALTER TABLE campaigns ADD CONSTRAINT budget_check CHECK (budget >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
