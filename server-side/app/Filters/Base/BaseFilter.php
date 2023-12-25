<?php

namespace App\Filters\Base;

use Illuminate\Http\Request;

class BaseFilter
{
    public int|string $id;
    public array $ids;
    public string $uuid;
    public string $date;
    public bool $deleted;

    public function __construct(Request $request = null)
    {
        if (!$request) {
            return;
        }

        $this->setFilters($request->all());

    }

    public function setFilters(array $filters): void
    {
        foreach ($filters as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * @return int|string
     */
    public function getId(): int|string
    {
        return $this->id;
    }

    /**
     * @param int|string $id
     */
    public function setId(int|string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getIds(): array
    {
        return $this->ids;
    }

    /**
     * @param array $ids
     */
    public function setIds(array $ids): void
    {
        $this->ids = $ids;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }




}




