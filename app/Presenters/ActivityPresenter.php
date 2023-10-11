<?php

namespace App\Presenters;

class ActivityPresenter
{
    /**
     * 活動類別選項陣列
     */
    protected $typeOption;

    public function __construct()
    {
        $this->typeOption = [
            (object) [
                'id' => 0,
                'name' => '活動列表',
            ],
            (object) [
                'id' => 1,
                'name' => '文化與藝術',
            ],
            (object) [
                'id' => 2,
                'name' => '學術與培訓',
            ],
            (object) [
                'id' => 3,
                'name' => '社交與社團',
            ],
            (object) [
                'id' => 4,
                'name' => '旅遊與戶外',
            ],
            (object) [
                'id' => 5,
                'name' => '健康與福祉',
            ],
            (object) [
                'id' => 6,
                'name' => '商業與職業發展',
            ],
            (object) [
                'id' => 7,
                'name' => '娛樂與文化慶典',
            ],
            (object) [
                'id' => 8,
                'name' => '科技與創新',
            ],
            (object) [
                'id' => 9,
                'name' => '其他',
            ],
        ];
    }

    /**
     * 回傳活動類別選項陣列
     * @return array 回傳活動類別選項陣列
     */
    public function getTypeOption()
    {
        return $this->typeOption;
    }

    /**
     * 回傳活動類別(type)名稱
     * @param int $type 類別
     * @return object 回傳活動類別(type)名稱
     */
    public function getActivityTypeName($type)
    {
        $typeData = (object) ['id' => 9, 'name' => '其他'];
        foreach ($this->typeOption as $value) {
            if ((int)($value->id) === (int)($type)) {
                $typeData = $value;
                break;
            }
        }

        return $typeData->name;
    }
}
