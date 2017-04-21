<?php

use yii\db\Migration;

class m170419_110711_model_name_field extends Migration {

    public function safeUp() {
        try {
            $this->addColumn('{{%field_value}}', 'model_name', $this->string(55));
        } catch (Exception $e) {
            echo 'Catch Exception ' . $e->getMessage() . ' ';
        }
    }

    public function safeDown() {
        try {
            $this->dropColumn('{{%field_value}}', 'model_name');
        } catch (Exception $e) {
            echo 'Catch Exception ' . $e->getMessage() . ' ';
        }
    }

}
