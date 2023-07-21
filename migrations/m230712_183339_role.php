<?php

use app\migrations\traits\ArrayTrait;
use app\migrations\traits\TimeTrait;
use app\migrations\traits\UuidTypeTrait;
use yii\db\Migration;

/**
 * Class m230712_183339_role
 */
class m230712_183339_role extends Migration {
    use UuidTypeTrait;
    use TimeTrait;
    use ArrayTrait;

    public static string $tableName = '{{%abac_role}}';

    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function safeUp(): void {
        $this->createTable(self::$tableName, [
            'id' => $this->uuid()->notNull(),
            'organization_id' => $this->uuid()->notNull(),

            'name' => $this->string(255)->notNull(),
            'full_access' => $this->boolean()->notNull()->defaultValue(false),
            'permissions' => $this->stringArray()->null()->defaultValue(null),

            'last_update_time' => $this->integerTime()->notNull(),
            'create_time' => $this->integerTime()->notNull()
        ]);

        $this->addPrimaryKey('pk_role', self::$tableName, 'id');
        $this->addForeignKey('fk_role_organization_id', self::$tableName, 'organization_id', '{{%organization}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable(self::$tableName);
        return true;
    }
}