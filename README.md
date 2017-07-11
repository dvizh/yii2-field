Yii2-field
==========

С помощью данного модуля можно добавить поля для какой-то модели через веб-интерфейс и потом производить выборки по значению.

Типы полей на данный момент:

* Text
* Numeric
* Date
* Textarea
* Select
* Radio
* Checkbox
* Image (в разработке)

Для select, radio, checkbox можно заранее задавать в настройках варианты.

Установка
---------------------------------

Выполнить команду

```
php composer require dvizh/yii2-field "@dev"
```

Или добавить в composer.json

```
"dvizh/yii2-field": "@dev",
```

И выполнить

```
php composer update
```

Далее, мигрируем базу:

```
php yii migrate --migrationPath=vendor/dvizh/yii2-field/src/migrations
```

Подключение и настройка
---------------------------------

В конфигурационный файл приложения добавить модуль field, настроив его

```php
    'modules' => [
        //...
        'field' => [
            'class' => 'dvizh\field\Module',
            'relationModels' => [
                'common\models\User' => 'Пользователи',
                'dvizh\shop\models\Product' => 'Продукты',
            ],
            'adminRoles' => ['administrator'],
        ],
        //...
    ]
```

* relationModels - перечень моделей, к которым можно прикрепить поля

Все доступные CRUD для управления полями: ?r=field/defailt/index

Для модели, с которой будут работать поля, добавить поведение:

```php 
    function behaviors() {
        return [
            'field' => [
                'class' => 'dvizh\field\behaviors\AttachFields',
            ],
        ];
    }
```

Чтобы иметь возможность также фильтровать результаты Find, подменяем Query в модели:

```php
    public static function Find()
    {
        $return = new ProductQuery(get_called_class());
        return $return;
    }
```

В ProductQuery должно быть это поведение:

```php
    function behaviors()
    {
       return [
           'field' => [
               'class' => 'dvizh\field\behaviors\Filtered',
           ],
       ];
    }
```

Использование
---------------------------------

Значение поля для модели вызывается через getField(), которому передается код поля.

```php
echo $model->getField('field_name');
```

Выбрать все записи по значению значению поля:

```php
$productsFind = Product::find()->field('power', 100)->all(); //Все записи с power=100
$productsFind = Product::find()->field('power', 100, '>')->all(); //Все записи с power>100
$productsFind = Product::find()->field('power', 100, '<')->all(); //Все записи с power<100
```

Виджеты
---------------------------------

Блок выбора значений для для полей модели $model (вставлять в админке, рядом с формой редактирования):

```php
<?=\dvizh\field\widgets\Choice::widget(['model' => $model]);?>
```

Вывести все поля модели со значениями:
```php
<?=dvizh\field\widgets\Show::widget(['model' => $model]);?>		
```
