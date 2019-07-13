<?php

use yii\db\Migration;

/**
 * Class m190624_185541_phone_numbers
 */
class m190624_185541_create_phone_numbers extends Migration
{
    /**
     * {@inheritdoc}
     */
//    public function safeUp()
//    {
//
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function safeDown()
//    {
//        echo "m190624_185541_phone_numbers cannot be reverted.\n";
//
//        return false;
//    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
    	$this->createTable('phone_numbers',[
    		'id'=>$this->primaryKey(),
		    'number'=>$this->bigInteger(),
		    'formatted_phone'=>$this->string(),
	    ]);

        $this->insert('{{%phone_numbers}}', ['number' => '9990001122']);
        $this->insert('{{%phone_numbers}}', ['number' => '9980001223']);
        $this->insert('{{%phone_numbers}}', ['number' => '9940007766']);
        $this->insert('{{%phone_numbers}}', ['number' => '9910006655']);
        $this->insert('{{%phone_numbers}}', ['number' => '9950005533']);

    }

    public function down()
    {
       $this->dropTable('phone_numbers');
    }

}
