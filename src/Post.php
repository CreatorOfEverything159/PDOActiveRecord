<?php

namespace Post;

use PDO;

class Post extends ActiveRecord
{
    private ?int $id;
    private string $postTitle;
    private string $postContent;

    /**
     * @param string $postTitle
     * @param string $postContent
     */
    public function __construct(string $postTitle, string $postContent, int $id = null)
    {
        $this->id = $id;
        $this->postTitle = $postTitle;
        $this->postContent = $postContent;
    }

    public static function remove($id): bool
    {
        if (Post::getById($id)) {
            self::connect();
            $connect = self::getConnection();

            $insertQuery = 'DELETE FROM post WHERE id=?';
            $query = $connect->prepare($insertQuery);
            $query->execute([$id]);

            self::unsetConnect();
            return true;
        }
        return false;
    }

    public static function getByID($id)
    {
        self::connect();
        $connect = self::getConnection();

        $insertQuery = 'SELECT * FROM post WHERE id=?';
        $query = $connect->prepare($insertQuery);
        $query->execute([$id]);
        $foundPost = $query->fetch();

        self::unsetConnect();

        if ($foundPost == false)
            return false;
        else return new Post($foundPost['title'],
            $foundPost['content'], $foundPost['id']);
    }

    public static function getAll(): array
    {
        self::connect();
        $connect = self::getConnection();

        $workers = array();

        // получаем наши таски
        foreach ($connect->query('select * from post order by id') as $line) {
            $worker = new Post(
                (string)$line['title'],
                (string)$line['content'],
                (int)$line['id']);

            $workers[] = $worker;
        }

        self::unsetConnect();
        return $workers;
    }

    public function save(): bool
    {
        $workerByFields = Post::getByFields($this->postTitle, $this->postContent);

        if ($workerByFields->postTitle != $this->postTitle && $workerByFields->postContent != $this->postContent) {
            self::connect();
            $connect = self::getConnection();

            $insertQuery = 'UPDATE post set title=:title, content=:content WHERE id=:id';
            $query = $connect->prepare($insertQuery);
            $query->execute(['title' => $this->postTitle, 'content' => $this->postContent, 'id' => $this->id]);

            self::unsetConnect();
            return true;
        } else return false;
    }

    public static function getByFields($title, $content)
    {
        self::connect();
        $connect = self::getConnection();

        $selectQuery = 'select * from post where title=:title and content=:content';
        $selectQuery = $connect->prepare($selectQuery);
        $selectQuery->execute(['title' => $title, 'content' => $content]);
        $foundWorker = $selectQuery->fetch();

        self::unsetConnect();

        if ($foundWorker == false)
            return false;
        else {
            return new Post($foundWorker['title'], $foundWorker['content'], $foundWorker['id']);

        }
    }

    /**
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        return self::$connection;
    }

    public function add(): bool
    {
        $foundPost = self::getByFields($this->postTitle, $this->postContent);
        if (!$foundPost) {
            self::connect();
            $connect = self::getConnection();

            $insertQuery = 'INSERT INTO post(title, content) VALUES(:title, :content)';
            $query = $connect->prepare($insertQuery);
            $query->execute(['title' => $this->postTitle, 'content' => $this->postContent]);

            self::unsetConnect();
            return true;
        } else return false;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPostTitle(): string
    {
        return $this->postTitle;
    }

    /**
     * @param string $postTitle
     */
    public function setPostTitle(string $postTitle): void
    {
        $this->postTitle = $postTitle;
    }

    /**
     * @return string
     */
    public function getPostContent(): string
    {
        return $this->postContent;
    }

    /**
     * @param string $postContent
     */
    public function setPostContent(string $postContent): void
    {
        $this->postContent = $postContent;
    }

}