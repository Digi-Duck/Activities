<?php

/**
 * 集合按照指定欄位去正序/倒序排列，這function僅限於該表有存在的欄位，需要排序關聯表的無法使用此function
 * @param collection $query 要排序的集合(集合要先用query()裝起來不要get())
 * @param string  $request_rules 要排序的欄位陣列(例: ['name' => '1'])
 */
function columnSort($query, $request_rules)
{
    if (!is_array($request_rules)) return $query;
    // 如果要排序，只會傳一個key value過來，此function回傳也只一筆
    $exist_rule = array_filter($request_rules, fn ($rule) => $rule);
    // 抓key name
    $column = key($exist_rule);
    // 如果有key，意即有$request->sortXXXXXXXXXXXXX，則以此key與其value正向/反向排序
    if (!$column) return $query;
    $query->orderBy($column, $exist_rule[$column] === '1' ? 'asc' : 'desc');
}

/**
 * 回傳給前端固定格式的物件
 * @param mixed $rt_data 要回傳給前端的資料
 * @param integer $rt_code 要回傳給前端的結果代碼(0:失敗；1:成功)
 * @param string $rt_message 要回傳給前端的結果訊息
 * @return object 回傳固定格式的物件
 */
function rtFormat($data = [], $code = 1, $message = '執行成功')
{
    $status = [0, 1];
    if (!is_int($code) || !in_array($code, $status) || !is_string($message)) {
        throw new Exception('rt_format函式傳入參數錯誤');
    }

    $format = (object) [
        'rt_code' => $code,
        'rt_message' => $message,
        'rt_data' => $data,
    ];

    return $format;
}
