<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/08/18
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

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
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('company_id')->after('id')->comment('会社ID');
            $table->string('description')->nullable()->after('name')->comment('権限の説明');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->string('company_id')->after('id')->comment('会社ID');
            $table->string('description')->nullable()->after('name')->comment('役割の説明');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('company_id');
            $table->dropColumn('description');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('company_id');
            $table->dropColumn('description');
        });
    }
};
