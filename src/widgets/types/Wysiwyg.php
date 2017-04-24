<?php
namespace dvizh\field\widgets\types;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use \yii\imperavi\Widget;
use Yii;

class Wysiwyg extends \yii\base\Widget
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

        $redactor = Widget::widget([
            'value' => $value,
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options'=>[
                'minHeight' => 400,
                'maxHeight' => 400,
                'buttonSource' => true,
                'imageUpload' => Url::toRoute(['tools/upload-imperavi'])
            ],
            'htmlOptions' => [
                'data-model-name' => $model::className(),
                'data-item-id' => $this->model->id,
                'data-id' => $this->field->id,
            ]
        ]);

        $input = Html::tag('div', $redactor, ['class' => 'dvizh-field-wysiwyg', 'style' => 'width: 98%; ', 'placeholder' => '']);
        $button = Html::tag('div', Html::button('<i class="glyphicon glyphicon-ok"></i>', ['class' => ' btn btn-success field-save-value']));
        
        $this->options['class'] .= ' input-group';
        $this->options['style'] = 'width: 100%;';
        $block = Html::tag('div', $input.$button, $this->options);

        return $block;
    }
}
