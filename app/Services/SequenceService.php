<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/02/14
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Services;

use App\Models\Sequence;
use App\Models\Employee;
use App\Models\Engineer;
use App\Models\Customer;
use App\Models\User;

class SequenceService
{
    /**
     * role別のユーザー番号を取得する
     * @return mixed
     */
    public function getNewUserNo(string $userRoleTypeKey, int $companyId)
    {
        return $this->getNewValueAndCommit(User::class . ':' . $userRoleTypeKey, $companyId);
    }

    /**
     * 社員番号を取得する
     * @return mixed
     */
    public function getNewEmployeeNum(int $companyId)
    {
        return $this->getNewValueAndCommit(Employee::class, $companyId);
    }

    /**
     * 技術者番号を取得する
     * @return mixed
     */
    public function getNewEngineerNum(int $companyId)
    {
        return $this->getNewValueAndCommit(Engineer::class, $companyId);
    }

    /**
     * 顧客番号を取得する
     * @return mixed
     */
    public function getNewCustomerNum(int $companyId)
    {
        return $this->getNewValueAndCommit(Customer::class, $companyId);
    }

    /**
     * 単純に新しい番号を取得する
     *
     * @param  string    $key      同じキー名を与えると前回の続きの値を返す
     * @return int|float $sequence 基本はintだがPHPの限界値を超えるとfloatになる
     */
    protected function getNewValueAndCommit(string $key, int $companyId)
    {
        // config/sequence.php という設定ファイルを作って初期値を用意しておける。
        // なければ 1 からスタート
        $default = config("sequence.default.$key", 1);

        // $sequence = Sequence::lockForUpdate()->find($key);
        $sequence = Sequence::where('key', $key)->where('company_id', $companyId)->lockForUpdate()->first();
        if (!$sequence) {
            $sequence = new Sequence;
            $sequence->key = $key;
            $sequence->company_id = $companyId;
        }

        if (($sequence->sequence ?? 0) < $default) {
            $sequence->sequence = $default;
        } else {
            $sequence->sequence = ($sequence->sequence ?? 0) + 1;
        }
        $sequence->save();

        return $sequence->sequence;
    }
}
