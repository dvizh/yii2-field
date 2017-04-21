<?php
namespace dvizh\field\controllers;

use yii;
use dvizh\field\models\FieldValue;
use dvizh\field\models\Field;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;


class FieldValueController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->adminRoles,
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'create' => ['post'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new FieldValue();

        $json = [];

        if ($model->load(yii::$app->request->post()) && $model->save()) {
            $json['result'] = 'success';
        } else {
            $json['result'] = 'fail';
            $json['error'] = $model->getErrors();
        }

        return json_encode($json);
    }

    public function actionUpdate()
    {
        $post = yii::$app->request->post('FieldValue');

        $model = FieldValue::findOne(['model_name' => $post['model_name'], 'item_id' => $post['item_id'], 'field_id' => $post['field_id']]);
        
        if(!$model) {
            $model = new fieldValue;
        } else {
            $field = field::findOne($model->field_id);
            if($field->type == 'radio') {
                FieldValue::deleteAll(['model_name' => $post['model_name'], 'item_id' => $post['item_id'], 'field_id' => $post['field_id']]);
                $model = new fieldValue;
            }
        }

        $json = [];

        if ($model->load(yii::$app->request->post()) && $model->save()) {
            $json['result'] = 'success';
        } else {
            $json['result'] = 'fail';
            $json['error'] = $model->getErrors();
        }

        return json_encode($json);
    }
    
    public function actionDelete()
    {
        $itemId = yii::$app->request->post('item_id');
        $variantId = yii::$app->request->post('variant_id');
        $fieldId = yii::$app->request->post('field_id');

        if($value = fieldValue::find()->where(['item_id' => $itemId, 'variant_id' => $variantId])->one()) {
            $value->delete();
        } else {
            FieldValue::deleteAll(['item_id' => $itemId, 'field_id' => $fieldId]);
        }

        return json_encode(['result' => 'success']);
    }

}
