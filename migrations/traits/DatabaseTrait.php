<?php

namespace app\migrations\traits;

use yii\db\Connection;

trait DatabaseTrait {
    /**
     * @return Connection the database connection to be used for schema building.
     */
    abstract protected function getDb();
}