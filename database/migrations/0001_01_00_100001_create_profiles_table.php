<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Models\User\SexType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id()->comment('プロフィールID');

            // ポリモーフィックリレーション
            // $table->morphs('profilable');

            // 個人情報
            $table->string('last_name')->comment('姓');
            $table->string('first_name')->comment('名');
            $table->string('last_name_kana')->nullable()->comment('セイ');
            $table->string('first_name_kana')->nullable()->comment('メイ');
            $table->date('date_of_birth')->nullable()->comment('生年月日');

            // 性別（ISO 5218準拠）
            $sexValues = collect(SexType::cases())->map(fn ($item) => $item->value)->toArray();
            $table->enum('sex_code', $sexValues)->length(1)->default('0')
                ->comment('性別コード ISO 5218: 0=not known（不明）、1=male（男性）、2=female（女性）、9=not applicable（適用不能）');

            // 連絡先
            $table->string('email')->nullable()->unique()->comment('メールアドレス');
            $table->string('phone', 16)->nullable()->comment('電話番号');
            $table->string('address', 255)->nullable()->comment('住所（レガシー）');

            // 詳細住所情報（新形式）
            $table->string('postal_code', 10)->nullable()->comment('郵便番号');
            $table->string('prefecture', 20)->nullable()->comment('都道府県');
            $table->string('city', 50)->nullable()->comment('市区町村');
            $table->string('street_address', 255)->nullable()->comment('町名番地等');

            $table->softDeletesDatetime()->comment('削除日');
            $table->datetimes();
            $table->unsignedInteger('created_by')->nullable()->comment('作成者');
            $table->unsignedInteger('updated_by')->nullable()->comment('変更者');
            $table->unsignedInteger('deleted_by')->nullable()->comment('削除者');
            $table->unsignedInteger('restored_by')->nullable()->comment('復元者');

            $table->comment('プロフィールテーブル');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
