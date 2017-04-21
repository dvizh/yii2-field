<?php
namespace dvizh\field\widgets\types;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use Yii;

class Numeric extends \yii\base\Widget
{
    public $model = NULL;
    public $field = null;
    public $options = [];
    
    public function init()
    {
        \dvizh\field\assets\ValueAsset::register($this->getView());
        parent::init();
    }

    public function run()
    {
        $variantsList = $this->field->variants;
        
        $variantsList = ArrayHelper::map($variantsList, 'id', 'value');
        $variantsList[0] = '-';
        ksort($variantsList);

        $value = $this->model->getField($this->field->slug);

        $model = $this->model;

        $input = Html::input('number', 'choice-field-value', $value, ['data-id' => $this->field->id, 'data-model-name' => $model::className(), 'data-item-id' => $this->model->id, 'class' => 'form-control', 'placeholder' => '']);
        $button = Html::tag('span', Html::button('<i class="glyphicon glyphicon-ok"></i>', ['class' => ' btn btn-success field-save-value']), ['class' => 'input-group-btn']);
        
        $this->options['class'] .= ' input-group';
        $block = Html::tag('div', $input.$button, $this->options);

        return $block;
    }
}
