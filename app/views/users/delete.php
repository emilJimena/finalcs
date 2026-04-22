<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/navigation.php'; ?>

<div class="container">
    <div class="content" style="max-width: 600px;">
        <h1>Delete User</h1>
        <p class="page-subtitle">Confirm user deletion</p>

        <?php if(!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif($user): ?>
            <div style="background: #fff3cd; padding: 15px; border-radius: 3px; margin-bottom: 20px; border-left: 4px solid #ffc107;">
                <p><strong>Are you sure you want to delete this user?</strong></p>
                <p style="margin-top: 10px; color: #7f8c8d;">
                    <strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?><br>
                    <strong>Account Type:</strong> <?php echo htmlspecialchars($user['account_type']); ?>
                </p>
                <p style="margin-top: 10px; color: #856404;">This action cannot be undone.</p>
            </div>

            <form method="POST" action="<?php echo \App\Core\Controller::urlToAction('user', 'delete', ['id' => $userId]); ?>">
                <div class="btn-group">
                    <button type="submit" class="btn btn-danger">Delete User</button>
                    <a href="<?php echo \App\Core\Controller::urlToAction('user', 'list'); ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
