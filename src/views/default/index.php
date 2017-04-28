<?php
use yii\helpers\Url;

$this->title = 'Поля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="model-index">
    <table class="table">
        <tr>
            <th>Поля</th>
            <td>
                <a href="<?=Url::toRoute(['/field/field/index']);?>" class="btn btn-default"><i class="glyphicon glyphicon-eye-open" /></i></a>
                <a href="<?=Url::toRoute(['/field/field/create']);?>" class="btn btn-default"><i class="glyphicon glyphicon-plus" /></i></a>
            </td>
        </tr>
        <tr>
            <th>Категории полей</th>
            <td>
                <a href="<?=Url::toRoute(['/field/category/index']);?>" class="btn btn-default"><i class="glyphicon glyphicon-eye-open" /></i></a>
                <a href="<?=Url::toRoute(['/field/category/create']);?>" class="btn btn-default"><i class="glyphicon glyphicon-plus" /></i></a>
            </td>
        </tr>
    </table>
</div>
