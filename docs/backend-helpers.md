# 《app/Http/Helpers》公用函式說明文件

## rtFormat函式使用說明：
```php
rtFormat(
  要回傳給前端的資料,
  要回傳給前端的結果代碼(選填，預設為1),
  要回傳給前端的結果訊息('選填，預設為執行成功)
);
```
>**※回傳的格式如下：**
```php
[
    'rt_code' => 要回傳給前端的結果代碼(0:失敗；1:成功),
    'rt_message' => 要回傳給前端的結果訊息,
    'rt_data' => 要回傳給前端的資料,
]
```
---