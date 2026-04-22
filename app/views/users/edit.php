<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/navigation.php'; ?>

<div class="container">
    <div class="content" style="max-width: 600px;">
        <h1>Edit User</h1>
        <p class="page-subtitle">Update user information</p>

        <?php if(!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="?controller=user&action=edit&id=<?php echo $userId; ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
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
                <button type="submit" class="btn">Update User</button>
                <a href="?controller=user&action=list" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
