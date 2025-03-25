<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="User management system dashboard">
    <title>User System | Profile</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <header class="main-header">
        <h1>User Dashboard</h1>
        <nav aria-label="Main navigation">
            <a href="/" class="nav-link">Home</a>
            <a href="/user" class="nav-link">My Profile</a>
        </nav>
    </header>

    <main class="user-content">
        <section aria-labelledby="user-info-heading">
            <h2 id="user-info-heading">User Information</h2>
            <!-- Dynamic content will be inserted here -->
            <div class="user-data">
                <p>Welcome to the user management system</p>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <p>&copy; <?= date('Y') ?> User Management System. All rights reserved.</p>
    </footer>

    <script src="/assets/js/main.js" defer></script>
</body>
</html>