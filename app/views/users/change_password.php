<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/navigation.php'; ?>

<div class="container">
    <div class="content" style="max-width: 600px;">
        <h1>Change Password</h1>
        <p class="page-subtitle">Update your account password</p>

        <?php if(isset($_GET['action']) && $_GET['action'] === 'changePassword' && $_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
            <div class="success-message">
                Password changed successfully!
            </div>
        <?php endif; ?>

        <?php if(!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="?controller=user&action=changePassword">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>

            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>

            <div class="form-group">
                <label for="new_password_confirm">Confirm New Password</label>
                <input type="password" id="new_password_confirm" name="new_password_confirm" required>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn">Change Password</button>
                <a href="?controller=home&action=index" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
