<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Enums\Models\User\RoleType;
use App\Enums\Models\User\IsApprovedType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('ユーザーID');
            $table->ulid('uuid')->index()->comment('ULID');
            $table->unsignedInteger('membership_number')->nullable()->comment('会員番号');

            $table->foreignId('company_id')->comment('会社ID')->constrained();
            $table->foreignId('profile_id')->nullable()->comment('プロフィールID')->constrained();

            $table->string('email')->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment('パスワード');

            // 権限のコメント作成
            $roleValues = collect(RoleType::cases())->map(fn ($item) => $item->value)->toArray();
            $roleComment = collect(RoleType::cases())
                // ->map(fn ($item) => "{$item}=" . RoleType::from($item)->label())
                ->map(fn ($item) => $item->value . "=" . $item->label())
                ->join('、');
            $table->enum('role', $roleValues)->default(RoleType::MEMBER->value)->comment('権限: ' . $roleComment);

            // $table->string('introducer_code')->nullable()->comment('紹介者コード');
            // $table->string('google_id')->nullable()->comment('Google Auth ID');

            // 承認フラグ
            $isApprovedValues = collect(IsApprovedType::cases())->map(fn ($item) => $item->value)->toArray();
            $isApprovedComment = collect(IsApprovedType::cases())
                // ->map(fn ($item) => "{$item}=" . IsApprovedType::from($item)->label())
                ->map(fn ($item) => $item->value . "=" . $item->label())
                ->join('、');
            // $table->unsignedTinyInteger('is_approved')->default(0)->comment('承認フラグ: 1=承認済み、0=未承認');
            $table->enum('is_approved', $isApprovedValues)->default(IsApprovedType::UNCONFIRMED->value)
                ->comment('承認フラグ: ' . $isApprovedComment);

            $table->rememberToken();
            $table->string('profile_photo_path', 2048)->nullable();

            $table->timestamp('last_login_at')->nullable()->comment('最終ログイン時間');

            $table->softDeletesDatetime()->comment('削除日');
            $table->datetimes();
            $table->unsignedInteger('created_by')->nullable()->comment('作成者');
            $table->unsignedInteger('updated_by')->nullable()->comment('変更者');
            $table->unsignedInteger('deleted_by')->nullable()->comment('削除者');
            $table->unsignedInteger('restored_by')->nullable()->comment('復元者');

            // 論理削除とユニーク制約を両立させる設定
            $table->boolean('exist')->nullable()->storedAs('case when deleted_at is null then 1 else null end')
                ->comment('存在フラグ: 論理削除とユニーク制約を両立させるためのフラグ');
            $table->unique(['email', 'role', 'exist']);

            $table->comment('ユーザーマスタ');
        });
        // ngramでFullTextSearchを実行するための設定
        // DB::statement("ALTER TABLE users ADD FULLTEXT index ftx_users_name (name) with parser ngram");
        // DB::statement("ALTER TABLE users ADD FULLTEXT index ftx_users_name_kana (name_kana) with parser ngram");
        DB::statement("ALTER TABLE users ADD FULLTEXT index ftx_users_email (email) with parser ngram");

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
