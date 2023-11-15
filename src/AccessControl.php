<?php

namespace uzdevid\abac;

use Yii;
use yii\base\Action;
use yii\base\ActionFilter;
use yii\base\Controller;
use yii\base\Exception;
use yii\web\ForbiddenHttpException;

class AccessControl extends ActionFilter {
    public array $permissions = [];

    public function events(): array {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    /**
     * @throws Exception
     */
    public function init(): void {
        parent::init();
    }

    /**
     * @param Action $action
     *
     * @throws ForbiddenHttpException
     */
    public function beforeAction($action): bool {
        $uniqueId = $action->uniqueId;

        if (isset($this->permissions[$uniqueId])) {
            $permission = $this->permissions[$uniqueId];
        } else {
            $permission = str_replace('/', '.', $uniqueId);
        }

        if (!$this->checkAccess($permission, Yii::$app->user->identity)) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        return true;
    }

    public function checkAccess(string $permission, IdentityPermissionInterface $identity): bool {
        $permissions = $identity->userPermissions();

        if (in_array('*', $permissions)) {
            return true;
        }

        return array_reduce($permissions, function ($carry, $item) use ($permission) {
            return $carry || fnmatch($item, $permission);
        }, false);
    }
}