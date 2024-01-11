<?php

declare(strict_types=1);

//This Service is going to interact with the database

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService
{
  public function __construct(private Database $db)
  {
  }

  //Validation of the email(through the datbase)
  public function isEmailTaken(string $email)
  {
    $emailCount = $this->db->query(
      "SELECT COUNT(*) FROM users WHERE email=:email",
      [
        'email' => $email
      ]
    )->count();

    if ($emailCount > 0) {
      throw new ValidationException(['email' => 'Email taken']);
    }
  }

  public function create(array $formData)
  {
    //Hashing password
    $password = password_hash($formData['password'], PASSWORD_BCRYPT, ['cost' => 12]);


    $this->db->query(
      "INSERT INTO users(email,age,country,password,social_media_url)
      VALUES(:email,:age,:country,:password,:url)",
      [
        'email' => $formData['email'],
        // 'password' => $formData['password'],
        'password' => $password,
        'age' => $formData['age'],
        'country' => $formData['country'],
        'url' => $formData['socialMediaURL']
      ]
    );
    //Authenticate regiestered users i.e logging in after creating a user
    session_regenerate_id();

    $_SESSION['user'] = $this->db->id();
  }

  public function login(array $formData)
  {
    $user = $this->db->query("SELECT * FROM users WHERE email=:email", [
      'email' => $formData['email']
    ])->find();

    $passwordMatch = password_verify($formData['password'], $user['password'] ?? '');

    if (!$user || !$passwordMatch) {
      throw new ValidationException(['password' => ['Invalid credentials']]);
    }

    //Update session Id after logging in
    session_regenerate_id();

    //if validation passes, update session to store users information
    $_SESSION['user'] = $user['id'];
  }

  public function logout()
  {
    //Deleteing session data 
    // unset($_SESSION['user']);

    //Destroy session
    session_destroy();

    //generate new id
    // session_regenerate_id();

    //Destroy cookie / The order of the $param values matter
    $params = session_get_cookie_params();
    setcookie(
      'PHPSESSID',
      '',
      time() - 3600,
      $params['path'],
      $params['domain'],
      $params['secure'],
      $params['httponly']
    );
  }
}
