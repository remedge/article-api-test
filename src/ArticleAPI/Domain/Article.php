<?php

namespace App\ArticleAPI\Domain;

class Article
{
    protected $id;

    protected $title;

    protected $body;

    private $createdAt;

    private $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body)
    {
        $this->body = $body;
    }

    public function setCreatedAt($timestamp)
    {
        $this->createdAt = $timestamp;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt($timestamp)
    {
        $this->updatedAt = $timestamp;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
