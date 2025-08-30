<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            // Добавляем недостающие поля
            if (!Schema::hasColumn('portfolios', 'client')) {
                $table->string('client')->nullable()->after('category_id');
            }
            if (!Schema::hasColumn('portfolios', 'project_date')) {
                $table->date('project_date')->nullable()->after('client');
            }
            if (!Schema::hasColumn('portfolios', 'project_url')) {
                $table->string('project_url')->nullable()->after('project_date');
            }
            if (!Schema::hasColumn('portfolios', 'technologies')) {
                $table->json('technologies')->nullable()->after('project_url');
            }
            if (!Schema::hasColumn('portfolios', 'gallery')) {
                $table->json('gallery')->nullable()->after('technologies');
            }
            if (!Schema::hasColumn('portfolios', 'features')) {
                $table->json('features')->nullable()->after('gallery');
            }
            if (!Schema::hasColumn('portfolios', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('features');
            }
            if (!Schema::hasColumn('portfolios', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
            if (!Schema::hasColumn('portfolios', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('portfolios', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('is_published');
            }
            if (!Schema::hasColumn('portfolios', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('published_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            // Удаляем добавленные поля при откате миграции
            $columns = [
                'client', 'project_date', 'project_url', 'technologies',
                'gallery', 'features', 'meta_title', 'meta_description',
                'meta_keywords', 'published_at', 'sort_order'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('portfolios', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
