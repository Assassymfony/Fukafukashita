<?php

namespace App\Entity;

class Posts
{

    private String $id;

    private String $idUser;

    private bool $isDream;

    private int $downVote;

    private int $upVote;

    private String $title;

    private String $body;

    private array $tags;

    public function __construct($id, $idUser, $isDream, $downVote, $upVote, $title, $body, $tags)
    {
        $this->id = $id;
        $this->idUser = $idUser;
        $this->isDream = $isDream;
        $this->downVote = $downVote;
        $this->upVote = $upVote;
        $this->title = $title;
        $this->body = $body;
        $this->tags = $tags;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function getDownVote(): int
    {
        return $this->downVote;
    }

    /**
     * @return String
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getIdUser(): string
    {
        return $this->idUser;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return int
     */
    public function getUpVote(): int
    {
        return $this->upVote;
    }

    /**
     * @return bool
     */
    public function isDream(): bool
    {
        return $this->isDream;
    }

}
