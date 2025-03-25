<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Welcome to our application homepage">
    <title><?= htmlspecialchars($title ?? 'Home Page') ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <header role="banner">
        <h1>Welcome to our Application</h1>
    </header>

    <main role="main">
        <section class="welcome-section">
            <h2 class="sr-only">Main Content</h2>
            <p>Discover all the features of our platform</p>
            
            <div class="cta-actions">
                <a href="/login" class="btn btn-primary">Sign In</a>
                <a href="/register" class="btn btn-secondary">Register</a>
            </div>
        </section>
    </main>

    <footer role="contentinfo">
        <p>&copy; <?= date('Y') ?> Company Name. All rights reserved.</p>
    </footer>

    <script src="/assets/js/main.js" defer></script>
</body>
</html>