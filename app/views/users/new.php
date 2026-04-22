<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/navigation.php'; ?>

<div class="container">
    <div class="content" style="max-width: 600px;">
        <h1>Add New User</h1>
        <p class="page-subtitle">Create a new system user</p>

        <?php if(!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo \App\Core\Controller::urlToAction('user', 'new'); ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirm Password</label>
                <input type="password" id="password_confirm" name="password_confirm" value="<?php echo htmlspecialchars($password_confirm); ?>" required>
            </div>

            <div class="form-group">
                <label for="account_type">Account Type</label>
                <select id="account_type" name="account_type" required>
                    <option value="">-- Select Account Type --</option>
                    <option value="admin" <?php echo $accountType === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="staff" <?php echo $accountType === 'staff' ? 'selected' : ''; ?>>Staff</option>
                    <option value="teacher" <?php echo $accountType === 'teacher' ? 'selected' : ''; ?>>Teacher</option>
                    <option value="student" <?php echo $accountType === 'student' ? 'selected' : ''; ?>>Student</option>
                </select>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn">Create User</button>
                <a href="<?php echo \App\Core\Controller::urlToAction('user', 'list'); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
