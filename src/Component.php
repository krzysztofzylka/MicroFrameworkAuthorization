<?php

namespace Krzysztofzylka\MicroFrameworkAuthorization;

use Krzysztofzylka\MicroFramework\View;

class Component extends \Krzysztofzylka\MicroFramework\Component\Component
{

    public function componentInit(): void
    {
        parent::componentInit();

        (new Auth())->init();

        View::$GLOBAL_VARIABLES['authorization'] = [
            'isAuth' => Account::isAuth(),
            'accountId' => Account::getAccountId(),
            'account' => Account::getAccount()
        ];
    }

}