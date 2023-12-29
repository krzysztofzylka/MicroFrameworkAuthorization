<?php

namespace Krzysztofzylka\MicroFrameworkAuthorization;

/**
 * Account class
 */
class Account
{

    /**
     * Account data
     * @var ?array
     */
    private static ?array $account = null;

    /**
     * Is authorization
     * @var bool
     */
    private static bool $auth = false;

    /**
     * Logged account ID
     * @var ?int
     */
    private static ?int $accountId = null;

    /**
     * Account is authorization
     * @return bool
     */
    public static function isAuth(): bool
    {
        return self::$auth;
    }

    /**
     * Get account ID
     * @return int|null
     */
    public static function getAccountId(): ?int
    {
        return self::$accountId;
    }

    /**
     * Get account
     * @return array|null
     */
    public static function getAccount(): ?array
    {
        return self::$account;
    }

    /**
     * Set account
     * @param array|null $account
     * @return void
     */
    public static function setAccount(?array $account): void
    {
        self::$account = $account;
    }

    /**
     * Set account ID
     * @param int|null $accountId
     * @return void
     */
    public static function setAccountId(?int $accountId): void
    {
        self::$accountId = $accountId;
    }

    /**
     * Set auth
     * @param bool $auth
     * @return void
     */
    public static function setAuth(bool $auth): void
    {
        self::$auth = $auth;
    }

}