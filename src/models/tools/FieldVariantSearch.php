<?php
namespace dvizh\field\models\tools;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use dvizh\field\models\FieldVariant;


class FieldVariantSearch extends FieldVariant
{
    public function rules()
    {
        return [
            [['id', 'field_id'], 'integer'],
            [['value'], 'safe'],
        ];
    }
    
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = FieldVariant::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'field_id' => $this->field_id,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
