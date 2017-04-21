<?php
namespace dvizh\field\models;

use yii;
use yii\helpers\Url;

class Category extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%field_category}}';
    }

    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sort' => 'Сортировка',
            'name' => 'Имя',
        ];
    }

    public function getFields()
    {
        return $this->hasMany(Field::className(), ['id' => 'field_id']);
    }
}
