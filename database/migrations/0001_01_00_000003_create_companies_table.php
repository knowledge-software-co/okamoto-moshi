<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/07/25
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
        Schema::create('companies', function (Blueprint $table) {
            $table->id()->comment('会社ID');

            $table->string('name')->comment('会社名');
            $table->string('representative')->nullable()->comment('代表者名');
            $table->string('phone')->nullable()->comment('電話番号');
            $table->string('address')->nullable()->comment('住所');
            $table->string('comment', 2000)->nullable()->comment('コメント');

            $table->string('advertising_payment_date')->nullable()->comment('広告費支払日');

            $table->integer('point')->nullable()->comment('ポイント');

            $table->boolean('is_paid')->default(false)->comment('支払済フラグ: 0:未払い, 1:支払済み');

            $table->softDeletesDatetime()->comment('削除日');
            $table->datetimes();
            $table->unsignedInteger('created_by')->nullable()->comment('作成者');
            $table->unsignedInteger('updated_by')->nullable()->comment('変更者');
            $table->unsignedInteger('deleted_by')->nullable()->comment('削除者');
            $table->unsignedInteger('restored_by')->nullable()->comment('復元者');

            $table->comment('会社マスタ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
