<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\User;
use Nette\Database\Explorer;
use Nette\Security\AuthenticationException;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;

class Authenticator implements \Nette\Security\Authenticator
{

    /** @var Explorer $database */
    private $database;

    /** @var Passwords $passwords */
    private $passwords;

    /** @var User $userModel */
    private $userModel;


    public function __construct(Explorer $connection, Passwords $passwords, User $user)
    {
        $this->database = $connection;
        $this->passwords = $passwords;
        $this->userModel = $user;
    }

    /**
     * @param string $user
     * @param string $password
     * @return SimpleIdentity
     * @throws AuthenticationException
     */
    public function authenticate(string $user, string $password): SimpleIdentity
    {
        $row = $this->userModel->getByUsername($user, TRUE);

        if (!$row)
        {
            throw new AuthenticationException('Zadaný uživatel neexistuje.');
        }

        if (!$this->passwords->verify($this->userModel->saltPassword($password, $row->salt), $row->password))
        {
            throw new AuthenticationException('Zadané heslo je neplatné.');
        }

        $userData = $row->toArray();
        unset($userData['password']);
        unset($userData['salt']);

        $this->userModel->setLastLoginDate($row->id);

        return new SimpleIdentity($row->id, 'admin', $userData);
    }

}
