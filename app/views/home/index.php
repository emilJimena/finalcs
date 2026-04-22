<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/navigation.php'; ?>

<div class="container">
    <div class="content">
        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <p class="page-subtitle">You are logged in as: <strong><?php echo htmlspecialchars($user['account_type']); ?></strong></p>

        <div style="margin-top: 30px;">
            <h2>Available Modules</h2>
            <ul style="margin-top: 20px; list-style-position: inside;">
                <li style="margin-bottom: 15px;">
                    <a href="<?php echo \App\Core\Controller::urlToAction('subject', 'list'); ?>" style="color: #3498db; text-decoration: none; font-weight: 500;">
                        📚 Subject Management
                    </a>
                    <p style="margin-left: 20px; color: #7f8c8d; font-size: 0.9em;">View and manage subjects</p>
                </li>
                <li style="margin-bottom: 15px;">
                    <a href="<?php echo \App\Core\Controller::urlToAction('program', 'list'); ?>" style="color: #3498db; text-decoration: none; font-weight: 500;">
                        🎓 Program Management
                    </a>
                    <p style="margin-left: 20px; color: #7f8c8d; font-size: 0.9em;">View and manage programs</p>
                </li>
                <?php if(\App\Core\Auth::isAdmin()): ?>
                <li style="margin-bottom: 15px;">
                    <a href="<?php echo \App\Core\Controller::urlToAction('user', 'list'); ?>" style="color: #3498db; text-decoration: none; font-weight: 500;">
                        👥 User Management
                    </a>
                    <p style="margin-left: 20px; color: #7f8c8d; font-size: 0.9em;">Admin: Manage system users</p>
                </li>
                <?php endif; ?>
                <li style="margin-bottom: 15px;">
                    <a href="<?php echo \App\Core\Controller::urlToAction('user', 'changePassword'); ?>" style="color: #3498db; text-decoration: none; font-weight: 500;">
                        🔐 Change Password
                    </a>
                    <p style="margin-left: 20px; color: #7f8c8d; font-size: 0.9em;">Update your account password</p>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
