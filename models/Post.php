<?php
class Post
{
    //DB stuff
    private $conn;
    private $table = 'posts';

    //Post Properties
    public $id;
    public $category_id;
    public $category_name;
    public $calltitleing_code;
    public $body;
    public $author;
    public $created_at;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Posts
    public function read()
    {
        //Create query
        $query = "SELECT
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                FROM
                    $this->table p
                LEFT JOIN
                    categories c ON p.category_id = c.id
                    ORDER BY
                    p.created_at DESC
                ";

        //Prepare statement
        $statement = $this->conn->prepare($query);

        //Execute query
        $statement->execute();

        return $statement;
    }

    //Get single post
    public function read_single()
    {
        // Create query
        $query = "SELECT 
                    c.name as category_name, 
                    p.id, 
                    p.category_id, 
                    p.title, 
                    p.body, 
                    p.author, 
                    p.created_at
                FROM  $this->table  p
                LEFT JOIN
                    categories c ON p.category_id = c.id
                WHERE
                    p.id = ?
                LIMIT 0,1";

        // Prepare statement
        $statement = $this->conn->prepare($query);

        // Bind ID
        $statement->bindParam(1, $this->id);

        // Execute query
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    //Create post
    public function create()
    {
        //Create query
        $query = "INSERT INTO $this->table 
                SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id";

        // Prepare statement
        $statement = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = (int) htmlspecialchars(strip_tags($this->category_id));

        //Bind Data
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':body', $this->body);
        $statement->bindParam(':author', $this->author);
        $statement->bindParam(':category_id', $this->category_id);

        //Execute Query
        if ($statement->execute()) {
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $statement->error);

        return false;
    }
}
