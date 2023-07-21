<?php

namespace uzdevid\abac;

interface IdentityPermissionInterface {
    public function userPermissions(): array;
}