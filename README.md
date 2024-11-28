# allego-package

這是練習用來自己撰寫 Composer 套件的專案

This is the project which is use to practice develop composer package by myself.

## 環境需求 Environment 
* composer ^2.8.x
* php ^8.3.x
* laravel ^10.10.x

## 安裝方式 Install

```php
composer require allego/package
```

## 使用方式 Usage

```php
use Test\Package\Test;
use Practice\Package\Practice;

$funcA = Test::Test();
echo $funcA; // It will display "Test"

$funcB = Practice::Practice();
echo $funcB; // It will display "Practice"
```

## Licens

[MIT ©️ 2024 Allego](LICENSE)
