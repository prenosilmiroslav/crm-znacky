<?php

declare(strict_types=1);

namespace App\Models;

use Nette\Database\Table\ActiveRow;
use Nette\Utils\ArrayHash;
use Nette\Utils\DateTime;
use Nette\Utils\Strings;

class Brand extends BaseModel
{

    /** @var string $tableName */
    private $tableName = 'brand';


    /**
     * Výběr všech značek z databáze podle zadaných parametrů
     *
     * @param array $options
     * @param int|NULL $length
     * @param int|NULL $offset
     * @return array|int
     */
    public function getAll(array $options = [], int $length = NULL , int $offset = NULL): array|int
    {
        $rows = $this->database->table($this->tableName);

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
                    $order = "name {$sort}";
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
     * Vrátí počet záznamů podle zadaných parametrů
     *
     * @param array $options
     * @return int
     */
    public function getCount(array $options = []): int
    {
        return $this->getAll(array_merge(['getCount' => TRUE], $options));
    }

    /**
     * Vytvoří nebo uloží změny u značky podle toho, zda jde o existující záznam
     *
     * @param ArrayHash $values
     * @param int|NULL $id
     * @return void
     */
    public function save(ArrayHash $values, int $id = NULL): void
    {
        $data = [
            'name' => Strings::trim($values->name),
        ];

        if (empty($id))
        {
            // Nová zančka
            $data['create_user_id'] = $values->user_id;
            $data['create_date'] = new DateTime();

            $this->database->table($this->tableName)->insert($data);
        }
        else
        {
            // Editace značky
            $data['update_user_id'] = $values->user_id;
            $data['last_update_date'] = new DateTime();

            $this->database->table($this->tableName)
                ->where('id = ?', $id)
                ->update($data);
        }
    }

    /**
     * Vrátí konkrétní značku
     *
     * @param int $id
     * @return ActiveRow|null
     */
    public function get(int $id): ?ActiveRow
    {
        return $this->database->table($this->tableName)
            ->where('id = ?', $id)
            ->fetch();
    }

    /**
     * Vrátí značku podle názvu
     *
     * @param string $name
     * @return ActiveRow|null
     */
    public function getByName(string $name): ?ActiveRow
    {
        return $this->database->table($this->tableName)
            ->where('name = ?', $name)
            ->fetch();
    }

    /**
     * Odstraní značku z databáze
     *
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        $this->database->table($this->tableName)->where('id = ?', $id)->delete();
    }

}
