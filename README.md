# 需求、變數修改說明:
  b. 依條件查詢學生 及 d. 新增一個學生 原來的 _method 改成 method
￼
# 部署說明:
  
>> 執行環境:
   1.docker
   2.docker-compose version 1.13.0

## 自動部署 
>> 測試主機環境有裝PHP、Compose，執行start.sh  
    
    sudo ./start.sh

>> 測試主機環境沒裝PHP、Compose 執行  start_without_php_compose  

    sudo ./start_without_php_compose.sh

##手動部署  

>> 部署環境:

    cd DockerImages
    docker-compose build
    docker-compose up -d
    

>>  安裝PHP、Composer (If necessary) 
    
    docker pull composer/composer  
    ln -s $PWD/composer.sh /usr/local/bin/composer  
    ln -s $PWD/php.sh /usr/local/bin/php 

>> 部署專案程式

    cd ../workspace/assignment
    cp .env.example .env
    composer install
    php artisan migrate:install
    php artisan migrate
>> 產生 預設資料
    php artisan db:seed

>> 測試 phpunit
>> 案例 對照測試方法 說明

>>> 查詢特定的學生 -> testQueryStudentById  

>>> 查詢特定的學生，發生錯誤情況 ->testQueryStudentByIdError  

>>> 依條件查詢學生 -> testQueryStudentByQuery  

>>> 查詢所有學生 -> testQueryStudentByAll  

>>> 新增一個學生 -> testAddStudent  

>>> 查詢各科成績的學生人數 -> testQueryGrade 

    vendor/bin/phpunit
>> 網頁Demo:
>>> This is [http://localhost:10080/assignments/](http://localhost:10080/assignments/ "http") 

>>> This is [https://localhost:10443/assignments/](https://localhost:10443/assignments/ "Https")     
    




