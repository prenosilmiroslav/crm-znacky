Agenda pro značky zboží
------------

Testovací aplikace pro agendu zboží k pohovoru. SQL soubor se strukturou, daty a 
ER diagram naleznete v adresáři `db`. 

**Pro přihlášení do aplikace využijte login `admin` a heslo `Admin.Heslo1`.**


Požadavky na verzi SW
------------

- PHP 8.2
- MySQL
- Nette 3.1


Instalace
------------

Po stažení kódu z GitLabu je potřeba udělat několik kroků

1. Nainstalovat balíčky příkazem `composer install`
2. Naimportovat SQL soubor (`db/sportisimo.sql`) do databázového serveru
3. Přejmenovat soubor `config/example.local.neon` na `config/local.neon`
4. Zadat přihlašovací údaje k databázi a název databáze v souboru `config/local.neon`
5. Případně nastavit práva pro zápis pro adresáře `temp/` a `log/`


Nastavení webového serveru
----------------

Pro jednoduché spuštění stačí v rootu projektu spustit v konzoli příkaz:

	php -S localhost:8000 -t www

Po zadání `http://localhost:8000` do prohlížeče, se zobrazí aplikace.

V případě využití Apache nebo Nginx stačí nasměrovat document root do adresáře `www/`.

