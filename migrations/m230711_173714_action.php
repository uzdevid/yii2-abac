<?php

use app\migrations\traits\UuidTypeTrait;
use yii\base\NotSupportedException;
use yii\db\Migration;

/**
 * Class m230713_173714_action
 */
class m230711_173714_action extends Migration {
    use UuidTypeTrait;

    public static string $tableName = '{{%abac_action}}';

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public function safeUp(): void {
        $this->createTable(self::$tableName, [
            'id' => $this->uuid()->notNull(),
            'action' => $this->string(255)->notNull()->unique(),
            'name' => $this->string(255)->notNull()
        ]);

        $this->addPrimaryKey('pk_action', self::$tableName, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable(self::$tableName);
        return true;
    }
}
