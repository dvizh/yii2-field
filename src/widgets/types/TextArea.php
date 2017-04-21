<?php
namespace dvizh\field\widgets\types;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use Yii;

class TextArea extends \yii\base\Widget
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

        $input = Html::textarea('choice-field-value', $value, ['data-id' => $this->field->id, 'data-model-name' => $model::className(), 'data-item-id' => $this->model->id, 'class' => 'form-control', 'style' => 'width: 98%;  height: 100px;', 'placeholder' => '']);
        $button = Html::tag('div', Html::button('<i class="glyphicon glyphicon-ok"></i>', ['class' => ' btn btn-success field-save-value']));
        
        $this->options['class'] .= ' input-group';
        $this->options['style'] = 'width: 100%;';
        $block = Html::tag('div', $input.$button, $this->options);

        return $block;
    }
}
