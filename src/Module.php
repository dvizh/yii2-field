<?php
namespace dvizh\field;

use yii;

class Module extends \yii\base\Module
{
    public $types = [
        'select' => 'Селект',
        'radio' => 'Радиобатон',
        'checkbox' => 'Чекбокс',
        'date' => 'Дата',
        'numeric' => 'Число',
        'text' => 'Текст',
        'textarea' => 'Текстарея',
        'wysiwyg' => 'Визуальный редактор',
        'image' => 'Картинка'
    ];
    public $relationModels = [];
    public $adminRoles = ['superadmin', 'admin', 'administrator'];

    public function init()
    {        
        parent::init();
    }
}