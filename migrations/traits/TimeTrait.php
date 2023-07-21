<?php

namespace app\migrations\traits;

use yii\db\ColumnSchemaBuilder;

trait TimeTrait {
    public function integerTime(): ColumnSchemaBuilder {
        return $this->bigInteger();
    }
}