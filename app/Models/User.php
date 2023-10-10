<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\BaseModel;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Security\Passwords;
use Nette\Utils\ArrayHash;
use Nette\Utils\DateTime;
use Nette\Utils\Random;
use Nette\Utils\Strings;

class User extends BaseModel
{

    const PASSWORD_SALT_LENGTH = 32;

    /** @var string $tableName */
    private $tableName = 'user';

    /** @var Passwords $passwords */
    private $passwords;


    public function __construct(Explorer $database, Passwords $passwords)
    {
        parent::__construct($database);
        $this->passwords = $passwords;
    }

    /**
     * Vrátí seznam všech uživatelů podle parametrů
     *
     * @param array $options
     * @param int|NULL $length
     * @param int|NULL $offset
     * @return array|int
     */
    public function getAll(array $options = [], int $length = NULL , int $offset = NULL): array|int
    {
        $columns = 'id, username, last_login_date';

        $rows = $this->database->table($this->tableName)->select($columns);

        // Počet záznamů
        if (!empty($options['getCount']))
        {
            return $rows->count('id');
        }

        // Řazení
        if (!empty($options['order']))
        {
            $sort = !empty($options['by']) && in_array(Strings::upper($options['by']), $this->allowSort) ? Strings::upper($options['by']) : $this->allowSort[0];

            switch ($options['order'])
            {
                case 'name':
                    $order = "username {$sort}";
                    break;

                case 'last_login_date':
                    $order = "last_login_date {$sort}";
                    break;

                default:
                    $order = 'id DESC';
            }

            $rows->order($order);
        }
        else
        {
            $rows->order('id DESC');
        }

        // Stránkování
        if (!empty($length))
        {
            $rows->limit($length, $offset);
        }

        return $rows->fetchAll();
    }

    /**
     * Vrátí počet záznamů
     *
     * @param array $options
     * @return int
     */
    public function getCount(array $options = []): int
    {
        return $this->getAll(array_merge(['getCount' => TRUE], $options));
    }

    /**
     * Vytvoří nového uživatele, nebo provede jeho editaci
     *
     * @param ArrayHash $values
     * @param int|NULL $id
     * @return void
     */
    public function save(ArrayHash $values, int $id = NULL): void
    {
        $data = [
            'username' => Strings::trim($values->username),
        ];

        if (empty($id))
        {
            // Nový uživatel
            // Nové heslo
            $data = $this->addGenerateSaltAndPassword(Strings::trim($values->password), $data);

            $this->database->table($this->tableName)->insert($data);
        }
        else
        {
            // Editace uživatele
            // Editace hesla
            if (!empty($values->password))
            {
                $data = $this->addGenerateSaltAndPassword(Strings::trim($values->password), $data);
            }

            $this->database->table($this->tableName)
                ->where('id = ?', $id)
                ->update($data);
        }
    }

    /**
     * Vygeneruje sůl a zahashuje heslo, to vše předá do pole, které je stupním parametrem
     *
     * @param string $password
     * @param array $data
     * @return array
     */
    private function addGenerateSaltAndPassword(string $password, array $data): array
    {
        $salt = $this->passwords->hash(Random::generate(self::PASSWORD_SALT_LENGTH));

        $data['salt'] = $salt;
        $data['password'] = $this->passwords->hash($this->saltPassword($password, $salt));

        return $data;
    }

    /**
     * Provede přisolení hesla
     *
     * @param string $password
     * @param string $salt
     * @return string
     */
    public function saltPassword(string $password, string $salt): string
    {
        return $password . $salt;
    }

    /**
     * Vybere uživatele z databáze podle ID
     *
     * @param int $id
     * @return ActiveRow|null
     */
    public function get(int $id): ?ActiveRow
    {
        $columns = 'id, username, last_login_date';

        return $this->database->table($this->tableName)
            ->select($columns)
            ->where('id = ?', $id)
            ->fetch();
    }

    /**
     * Vybere uživatele z databáze podle přihlašovacího jména
     *
     * @param string $username
     * @return ActiveRow|null
     */
    public function getByUsername(string $username, bool $withCreditinals = FALSE): ?ActiveRow
    {
        $columns = 'id, username, last_login_date';

        if ($withCreditinals)
        {
            $columns .= ', password, salt';
        }

        return $this->database->table($this->tableName)
            ->select($columns)
            ->where('username = ?', $username)
            ->fetch();
    }

    /**
     * Odstranění uživatele z databáze
     *
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        $this->database->table($this->tableName)->where('id = ?', $id)->delete();
    }

    /**
     * Záznam posledního přihlášení do databáze
     *
     * @param int $id
     * @return void
     */
    public function setLastLoginDate(int $id): void
    {
        $this->database->table($this->tableName)
            ->where('id = ?', $id)
            ->update(['last_login_date' => new DateTime()]);
    }

}
