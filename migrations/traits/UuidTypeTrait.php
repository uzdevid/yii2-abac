<?php

namespace app\migrations\traits;

use yii\base\NotSupportedException;
use yii\db\ColumnSchemaBuilder;

trait UuidTypeTrait {
    use DatabaseTrait;

    /**
     * Creates a uuid column.
     * @return ColumnSchemaBuilder the column instance which can be further customized.
     * @throws NotSupportedException
     */
    public function uuid(): ColumnSchemaBuilder {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('uuid');
    }
}