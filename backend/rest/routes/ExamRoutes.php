<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::route('GET /', function () {
    Flight::json([
        "message" => "web-programming-makeup REST API is running",
        "endpoints" => [
            "/film/performance"
        ]
    ]);
});

Flight::route('POST /login', function () {
    /** TODO
     * This endpoint is used to login user to system
     * you can use email: demo.user@gmail.com and password: 123 (password is stored within db as plain - 123) to login
     * Output should be array containing success message, JWT, and user object
     * This endpoint should return output in JSON format
     * 5 points
     */
});

Flight::route('GET /film/performance', function () {
    /** TODO
     * This endpoint returns performance report for every film category.
     * It should return array of all categories where every element
     * in array should have following properties
     *   `id` -> id of category
     *   `name` -> category name
     *   `total` -> total number of movies that belong to that category
     * This endpoint should return output in JSON format
     * 10 points
     */
  try {
    Flight::json(Flight::examService()->film_performance_report());
  } catch (Exception $e) {
    throw $e;
  }
});

Flight::route('DELETE /film/delete/@film_id', function ($film_id) {
    /** TODO
     * This endpoint should delete the film from database with provided id.
     * This endpoint should return output in JSON format that contains only 
     * `message` property that indicates that process went successfully.
     * 5 points
     */
  try {
    $res = Flight::examService()->delete_film($film_id);
    Flight::json(["message" => "Process went successfully!"]);
  }
  catch (\Exception $e) {
    throw $e;
  }
});

Flight::route('PUT /film/edit/@film_id', function ($film_id) {
    /** TODO
     * This endpoint should save edited film to the database.
     * The data that will come from the form has following properties
     *   `title` -> title of the film
     *   `description` -> description of the film
    *   `release_year` -> release_year of the film
     * This endpoint should return the edited customer in JSON format
     * 10 points
     */
  try {
    $data = Flight::request()->data->getData();

    $res = Flight::examService()->edit_film($film_id, $data);
    Flight::json($res);
  }
  catch (\Exception $e) {
    throw $e;
  }
});

Flight::route('GET /customers/report', function () {
    /** TODO
     * This endpoint should return the report for every customer in the database.
     * For every customer we need the amount of money earned from customer rentals. 
     * The data should be summarized in order to get accurate report. 
     * Every item returned should have following properties:
     *   `details` -> the html code needed on the frontend. Refer to `customers.html` page
     *   `customer_full name` -> first and last name of customer concatenated
     *   `total_amount` -> aggregated amount of money earned from rentals per customer
     * This endpoint should return output in JSON format
     * 10 points
     */
});

Flight::route('GET /rentals/customer/@customer_id', function ($customer_id) {
    /** TODO
     * This endpoint should return the array of all rentals from the customer
     * Every item returned should have 
     * following properties:
     *   `rental_date` -> rental_date 
     *   `film_title` -> title of the film 
     *   `payment_amount` -> amount of payment for given rental
     * This endpoint should return output in JSON format
     * 10 points
     */
  try {
    Flight::json(Flight::examService()->get_customer_rental_details($customer_id));
  }
  catch (\Exception $e) {
    throw $e;
  }
});
