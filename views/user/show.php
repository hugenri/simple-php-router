<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'User Details') ?></title>
    <style>
        .user-details { margin: 2rem; max-width: 600px; }
        .actions { margin-top: 1.5rem; display: flex; gap: 1rem; }
        .delete-btn { background-color: #f44336; color: white; }
    </style>
</head>
<body>
    <main class="user-details" aria-labelledby="user-heading">
        <h1 id="user-heading">User Details</h1>
        
        <div class="user-info">
            <p><strong>ID:</strong> <?= htmlspecialchars($user['id'] ?? 'N/A') ?></p>
            <p><strong>Name:</strong> <?= htmlspecialchars($user['name'] ?? 'Not provided') ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? 'Not provided') ?></p>
        </div>

        <div class="actions">
            <a href="/users/<?= htmlspecialchars($user['id']) ?>/edit" 
               class="button" 
               aria-label="Edit user <?= htmlspecialchars($user['name']) ?>">
                Edit
            </a>
            
            <form action="/users/<?= htmlspecialchars($user['id']) ?>/delete" 
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this user?')">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="delete-btn">
                    Delete
                </button>
            </form>
        </div>
    </main>

    <script>
        // Confirm before delete action
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this user?')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>