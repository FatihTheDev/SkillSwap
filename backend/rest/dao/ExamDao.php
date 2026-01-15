<?php

class ExamDao
{

  private $conn;

  /**
   * constructor of dao class
   */
  public function __construct()
  {
    try {
      /** TODO
       * List parameters such as servername, username, password, schema. Make sure to use appropriate port
       */
      $servername = 'localhost';
      $schema = 'final-makeup';
      $dbPort = 3306;
      $username = 'root';
      $password = '';

      /** TODO
       * Create new connection
       */
      $this->conn = new PDO(
        "mysql:host=" . $servername . ";dbname=" . $schema . ";port=" . $dbPort, $username, $password,
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
      );
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  public function login($data) {}

  public function film_performance_report() {
    $sql = "
    SELECT c.category_id AS id,
    c.name AS name ,
    COUNT(fc.film_id) as total
    FROM category c
    LEFT JOIN film_category fc ON fc.category_id = c.category_id
    GROUP BY c.category_id
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll();
    return $res;
  }

  public function delete_film($film_id) {
    $sql = "
    DELETE 
    FROM film 
    WHERE film_id = :id;
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([":id" => $film_id]);
  }

  public function edit_film($film_id, $data) {
    $sql = "
    UPDATE film 
    SET title = :title,
    description = :desc,
    release_year = :ry
    WHERE film_id = :id;
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([":title" => $data["title"], ":desc" => $data["description"],
      ":ry" => $data["release_year"], ":id" => $film_id]);

    $sql = "
    SELECT title, description, release_year
    FROM film 
    WHERE film_id = :id;
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([":id" => $film_id]);
    $res = $stmt->fetch();
    return $res;
  }

  public function get_customers_report() {}

  public function get_customer_rental_details($customer_id) {
    $sql = "
    SELECT r.rental_date as rental_date,
    SUM(p.amount) AS payment_amount
    FROM rental r
    JOIN payment p ON p.rental_id = r.rental_id
    JOIN customer c ON c.customer_id = r.customer_id
    WHERE c.customer_id = :id
    GROUP BY r.rental_id
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([":id" => $customer_id]);
    $res = $stmt->fetchAll();
    return $res;
  }
}
