<?php

namespace App\Domain\Team\Models;

class Team
{
    private ?int $id;
    private string $name;
    private ?string $description;
    private int $ownerId;

    public function __construct(
        string $name,
        ?string $description = null,
        int $ownerId,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->ownerId = $ownerId;
    }

    /**
     * Team IDの取得
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * Team名の取得
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Teamの説明の取得
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }


    /**
     * オーナーIDの取得
     *
     * @return integer
     */
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }
}
