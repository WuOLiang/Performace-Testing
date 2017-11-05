# 序號產生器

## 測試環境
* MAC OS X
* PHP 7.0 CLI Docker
* Mysql 5.7 Docker

## 情境說明
* every\_time\_insert - 每產生一筆即寫入資料庫
    以亂數產生八碼英數混合序號。
    以序號當條件對DB進行select count，檢查有無重複。
    寫入資料庫。

* one\_time\_insert - 暫存在陣列，產生完成預定筆數一次寫入資料庫
    以亂數產生八碼英數混合序號。
    對陣列檢查有無重複，寫入陣列。
    產生到達預定筆數，寫入DB。

## 其他
* no_index.sql 未建立 index 之資料表結構
* has_index.sql 已建立 index 之資料表結構