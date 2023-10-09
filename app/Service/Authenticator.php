<?php

namespace App\Service;

use Nette\Database\Explorer;
use Nette\Security\AuthenticationException;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;

class Authenticator implements \Nette\Security\Authenticator
{

    /** @var string $tableName*/
    private $tableName = 'user';

    /** @var Explorer $database */
    private $database;

    /** @var Passwords $passwords */
    private $passwords;


    public function __construct(Explorer $connection, Passwords $passwords)
    {
        $this->database = $connection;
        $this->passwords = $passwords;
    }

    /**
     * @param string $user
     * @param string $password
     * @return SimpleIdentity
     * @throws AuthenticationException
     */
    public function authenticate(string $user, string $password): SimpleIdentity
    {
        $row = $this->database->table($this->tableName)
            ->where('username = ?', $user)
            ->fetch();

        if (!$row)
        {
            throw new AuthenticationException('Zadaný uživatel neexistuje.');
        }

        if (!$this->passwords->verify($password . $row->salt, $row->password))
        {
            throw new AuthenticationException('Zadané heslo je neplatné.');
        }

        $userData = $row->toArray();
        unset($userData['password']);
        unset($userData['salt']);

        return new SimpleIdentity($row->id, 'admin', $userData);
    }

}
