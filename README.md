# Komponent autoryzacji

# Inicjacja komponentu
## Pobranie paczki composera:
```bash
composer require krzysztofzylka/micro-framework-authorization
```
## Dodajemy do component.json:
```
\Krzysztofzylka\MicroFrameworkAuthorization\Component
```

# Metody
## Sprawdzenie czy użytkownik jest zalogowany
```php
\Krzysztofzylka\MicroFrameworkAuthorization\Account::isAuth()
```
## Pobranie id zalogowaniego użytkownika
```php
\Krzysztofzylka\MicroFrameworkAuthorization\Account::getAccountId()
```
## Pobranie danych zalogowanego użytkownika
```php
\Krzysztofzylka\MicroFrameworkAuthorization\Account::getAccount()
```
## Rejestracja użytkownika
```php
$auth = new \Krzysztofzylka\MicroFrameworkAuthorization\Auth();
$auth->register('login', 'password')
```
### Return
bool
### Zwracane błędy AuthorizationException:
- Authorization is disabled
## Logowanie użytkownika
```php
$auth = new \Krzysztofzylka\MicroFrameworkAuthorization\Auth();
$auth->login('login', 'password')
```
### Return
bool
## Wylogowanie użytkownika
```php
$auth = new \Krzysztofzylka\MicroFrameworkAuthorization\Auth();
$auth->logout();
```