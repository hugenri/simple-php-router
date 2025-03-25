# PHP Routing Framework

## Overview

This is a lightweight, flexible PHP routing framework that provides a simple and powerful way to manage HTTP routes in your web application. The framework supports multiple HTTP methods, dynamic route parameters, middleware integration, and clean URL handling.

## Features

- 🚦 Simple route definitions (GET, POST, PUT, DELETE)
- 🛡️ Middleware support
- 🌐 RESTful routing
- 📦 No external dependencies
- ⚡ Fast execution

## Requirements

- PHP 7.4+
- Apache or Nginx web server with mod_rewrite enabled

## Installation

1. Clone the repository:
```bash
 git clone https://github.com/hugenri/simple-php-router.git
cd simple-php-router
```

2. Configure your `.env` file with your base URL and other environment settings

## Route Configuration Example

```php
$router->get('/', 'HomeController@index');
$router->get('/user/{id}', 'UserController@show')->middleware('AuthMiddleware');
$router->post('/user', 'UserController@create')->middleware('AuthMiddleware');
```

## Middleware Usage

```php
class AuthMiddleware {
    public function handle() {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo "Unauthorized access";
            exit;
        }
    }
}
```

## Project Structure

```
project/
│
├── controllers/
│   ├── HomeController.php
│   └── UserController.php
│
├── core/
│   ├── Autoloader.php
│   ├── BaseController.php
│   ├── BaseModel.php
│   ├── Database.php
│   ├── EnvLoader.php
│   ├── LoadRoutes.php
│   ├── Redirect.php
│   ├── Router.php
│   └── View.php
│
├── middlewares/
│   └── AuthMiddleware.php
│
├── models/
│   └── UserModel.php
│
├── routes/
│   └── Routes.php
│
├── views/
│   ├── home.php
│   └── user/
│       ├── index.php
│       └── show.php
│
├── .env
├── .htaccess
└── index.php
```

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please open an issue or submit a pull request.

## License

This project is licensed under the GNU General Public License v3.0 (GPL-3.0).

The GNU General Public License is a free, copyleft license for software and other kinds of works. It ensures that the software remains free and that any modifications or improvements are also shared with the community.

You should have received a copy of the GNU General Public License along with this program. If not, see [https://www.gnu.org/licenses/](https://www.gnu.org/licenses/).

