<?php
namespace dvizh\field\widgets\types;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use Yii;

class Radio extends \yii\base\Widget
{
    public $model = NULL;
    public $field = null;
    public $options = [];
    
    public function init()
    {
        \dvizh\field\assets\VariantsAsset::register($this->getView());
        parent::init();
    }

    public function run()
    {
        $variantsList = $this->field->variants;
        
        $variantsList = ArrayHelper::map($variantsList, 'id', 'value');
        ksort($variantsList);

        $checked = $this->model->getFieldVariantId($this->field->slug);

        $radio = Html::radioList('choice-field-value', $checked, $variantsList);
        
        $variants = Html::tag('div', $radio, $this->options);

        return $variants;
    }
}
