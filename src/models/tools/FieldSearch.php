<?php
namespace dvizh\field\models\tools;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use dvizh\field\models\Field;

class FieldSearch extends Field
{
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['name', 'slug', 'type', 'description', 'relation_model'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }
    
    public function search($params)
    {
        $query = Field::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new \yii\data\Sort([
                'attributes' => [
                    'name',
                    'type',
                    'relation_model',
                    'category_id'
                ],
            ])
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'category_id' => $this->category_id,
            'relation_model' => $this->relation_model,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
