<?php

use yii\db\Migration;

class m170207_135744_add_date_to_comment extends Migration
{


    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    $this->addColumn('comment','date', $this->date());
    }

    public function safeDown()
    {
            $this->dropColumn('comment','date');

    }

}
