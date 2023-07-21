<?php
namespace uzdevid\abac;

use Yii;
use yii\base\Action;
use yii\base\ActionFilter;
use yii\base\Controller;
use yii\base\Exception;
use yii\di\NotInstantiableException;
use yii\web\ForbiddenHttpException;
use yii\web\IdentityInterface;

class AccessControl extends ActionFilter {
    public function events(): array {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    /**
     * @throws Exception
     */
    public function init(): void {
        parent::init();

        if (!(Yii::$app->user->identity instanceof IdentityPermissionInterface)) {
            throw new NotInstantiableException(Yii::$app->user->identity, 'User must implement IdentityPermissionInterface');
        }
    }

    /**
     * @param Action $action
     * @throws ForbiddenHttpException
     */
    public function beforeAction($action): bool {
        $uniqueId = $action->uniqueId;

        $permission = str_replace('/', '.', $uniqueId);

        if (!$this->checkAccess($permission, Yii::$app->user->identity)) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        return true;
    }

    public function checkAccess(string $permission, IdentityInterface $user): bool {
        $permissions = $user->userPermissions();

        if (in_array('*', $permissions)) {
            return true;
        }

        return array_reduce($permissions, function ($carry, $item) use ($permission) {
            return $carry || fnmatch($item, $permission);
        }, false);
    }
}