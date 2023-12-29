<?php

namespace Krzysztofzylka\MicroFrameworkAuthorization;

use krzysztofzylka\DatabaseManager\CreateTable;
use krzysztofzylka\DatabaseManager\Table;
use Krzysztofzylka\Hash\Hash;
use Krzysztofzylka\MicroFramework\Extension\DebugBar\DebugBar;
use Krzysztofzylka\MicroFrameworkAuthorization\Exception\AuthorizationException;

/**
 * Authorization
 */
class Auth
{

    /**
     * Hash algorithm
     * @var string
     */
    public static string $hashAlgorithm = 'pbkdf2';

    /**
     * Table instance
     * @var Table
     */
    private static Table $tableInstance;

    /**
     * Constructor
     */
    public function init(): void
    {
        self::$tableInstance = new Table('account');

        if (!self::$tableInstance->exists()) {
            $createTable = new CreateTable();
            $createTable->setName('account');
            $createTable->addIdColumn();
            $createTable->addSimpleVarcharColumn('email', 128);
            $createTable->addSimpleVarcharColumn('password', 80);
            $createTable->addDateModifyColumn();
            $createTable->addDateCreatedColumn();
            $createTable->execute();
        }

        if (isset($_SESSION[$_ENV['AUTHORIZATION_SESSION_NAME']])) {
            DebugBar::timeStart('account', 'Initialize account');
            Account::setAccountId($_SESSION[$_ENV['AUTHORIZATION_SESSION_NAME']]);
            Account::setAuth(true);
            $findAccount = self::$tableInstance->find(['account.id' => Account::getAccountId()]);
            Account::setAccount($findAccount);
            DebugBar::timeStop('account');
            DebugBar::addFrameworkMessage('Account logged by session ' . Account::getAccountId(), 'Account');
        }
    }

    /**
     * Login account
     * @param string $login
     * @param string $password
     * @return bool
     * @throws AuthorizationException
     */
    public function login(string $login, string $password): bool
    {
        try {
            $password = Hash::hash($password, self::$hashAlgorithm);
            $findAccount = self::$tableInstance->find(
                ['account.email' => $login, 'account.password' => $password]
            );

            if (!$findAccount) {
                return false;
            }

            Account::setAccount($findAccount['account']);
            Account::setAccountId($findAccount['account']['id']);
            Account::setAuth(true);
            $_SESSION[$_ENV['AUTHORIZATION_SESSION_NAME']] = $findAccount['account']['id'];

            return true;
        } catch (\Exception $exception) {
            throw new AuthorizationException($exception);
        }
    }

    /**
     * Register account
     * @param string $login
     * @param string $password
     * @return bool
     * @throws AuthorizationException
     */
    public function register(string $login, string $password): bool
    {
        if (!$_ENV['AUTHORIZATION_REGISTER']) {
            throw new AuthorizationException('Authorization is disabled');
        }

        try {
            $password = Hash::hash($password, self::$hashAlgorithm);
            $findAccount = self::$tableInstance->findIsset(['account.email' => $login]);

            if ($findAccount) {
                return false;
            }

            self::$tableInstance->insert(['email' => $login, 'password' => $password]);

            return true;
        } catch (\Exception $exception) {
            throw new AuthorizationException($exception);
        }
    }

    /**
     * Logout account
     * @return void
     */
    public function logout(): void
    {
        Account::setAccount(null);
        Account::setAccountId(null);
        Account::setAuth(false);
        unset($_SESSION[$_ENV['AUTHORIZATION_SESSION_NAME']]);
    }

}