<?php
namespace dvizh\field\behaviors;

use yii;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use dvizh\field\models\FieldValue;
use dvizh\field\models\FieldVariant;
use dvizh\field\models\Field;

class Filtered extends Behavior
{
    public $fieldName = 'field';
    
    public function field($key, $value, $sign = '=')
    {
        if(!is_array($value)) {
            $value = [$value];
        }

        $field = Field::findOne(['slug' => $key]);

        if(!$field) {
            throw new \yii\base\Exception('Field do not find');
        }
        
        $numeric_value = (int)current($value);
        
        if($sign == '=') {
            $variants = FieldVariant::findAll(['field_id' => $field->id, 'value' => $value]);
        } elseif($sign == '>') {
            $variants = FieldVariant::find()->where('field_id = :field_id AND numeric_value > :value', [':field_id' => $field->id, ':value' => $numeric_value])->all();
        } else {
            $variants = FieldVariant::find()->where('field_id = :field_id AND numeric_value < :value', [':field_id' => $field->id, ':value' => $numeric_value])->all();
        }

        $fieldIds = [];

        foreach($variants as $variant) {
            $fieldIds[$field->id][] = $variant->id;
        }

        if(empty($fieldIds)) {
            return $this->owner->andWhere(['id' => 0]);
        }

        return $this->filtered($fieldIds, 2);
    }

    public function filtered($fieldIds = false, $mode = 0)
    {
        if(!$fieldIds) {
            $fieldIds = Yii::$app->request->get($this->fieldName);
        }

        if(empty($fieldIds)) {
            return $this->owner;
        }

        $condition = ['OR'];
        $variantCount = 0;

        foreach($fieldIds as $fieldId => $value) {
            $field = Field::findOne($fieldId);
            if($field->type == 'range' && is_string($value)) {
                $value = explode(';', $value);
                if($value[0] != $value[1]) {
                    $variants = FieldVariant::find()->where('field_id = :fieldId AND (numeric_value >= :min AND numeric_value <= :max)', [':fieldId' => $fieldId, ':min' => $value[0], ':max' => $value[1]])->select('id')->all();
                } else {
                    $variants = FieldVariant::find()->where('field_id = :fieldId AND numeric_value = :value', [':fieldId' => $fieldId, ':value' => $value[0]])->select('id')->all();
                }
                $variantIds = ArrayHelper::map($variants, 'id', 'id');
            } else {
                $variantIds = $value;
            }

            $condition[] = ['field_id' => $fieldId, 'variant_id' => $variantIds];

            if($mode == 1) {
                $variantCount += count($variantIds);
            } else {
                $variantCount++;
            }

        }

        $filtered = FieldValue::find()->select('item_id')->groupBy('item_id')->andHaving("COUNT(DISTINCT `field_id`) = $variantCount")->andFilterWhere($condition);

        if($filtered->count() > 0) {
            $this->owner->andWhere(['id' => $filtered]);
        } else {
            $this->owner->andWhere(['id' => 0]);
        }

        return $this->owner;
    }
}
