# 說明
* SnGenTest.php 主程式

## 資料表未建立index
### 測試1
條件:
* 十萬筆序號
* 資料表為空。

結果:
* 未碰撞。
* 佔用記憶體：8MB
* 所需時間：約1分40秒

## 測試2
條件:
* 十萬筆序號
* 資料表已存放十萬筆資料。

結果:
* 未碰撞。
* 佔用記憶體：8MB
* 所需時間：約1分40秒

## 資料表有建立index
### 測試1
條件:
* 十萬筆序號
* 資料表為空。

結果:
* 未碰撞。
* 佔用記憶體：8MB
* 所需時間：約1分50秒

## 測試2
條件:
* 十萬筆序號
* 資料表已存放十萬筆資料。

結果:
* 未碰撞。
* 佔用記憶體：8MB
* 所需時間：約1分50秒