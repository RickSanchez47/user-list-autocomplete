# Laravel User Management System

Welcome to the Laravel User Management System! This system allows you to manage users, departments, and designations.

## Installation

- Clone the repository:
  ```bash
  git clone <repository_url>

1 cd laravel-user-management
2 composer install
3 cp .env.example .env
4 php artisan key:generate
5 php artisan migrate
6 php artisan db:seed
7 php artisan serve

Features

    View a list of users with their departments and designations
    Create users
    Search for users by name, department, or designation
