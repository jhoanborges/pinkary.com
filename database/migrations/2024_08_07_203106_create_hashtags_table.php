<?php

declare(strict_types=1);

use App\Models\Hashtag;
use App\Models\Question;
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
        Schema::create('hashtags', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Crear un índice que ignore las mayúsculas usando la función LOWER
        Schema::table('hashtags', function (Blueprint $table): void {
            $table->index([DB::raw('lower(name)')], 'hashtags_name_lower_index');
        });

        Schema::create('hashtag_question', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Hashtag::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Question::class)->constrained()->cascadeOnDelete();

            $table->unique(['hashtag_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hashtag_question');
        Schema::dropIfExists('hashtags');
    }
};
