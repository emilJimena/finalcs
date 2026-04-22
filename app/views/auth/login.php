<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <div style="max-width: 400px; margin: 100px auto; background: white; padding: 40px; border-radius: 3px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);">
        <h1 style="text-align: center; margin-bottom: 8px; color: #2c3e50; font-size: 1.5em;">School Encoding Module</h1>
        <p style="text-align: center; color: #7f8c8d; margin-bottom: 20px; font-size: 0.9em;">Login to your account</p>

        <?php if(!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo \App\Core\Controller::urlToAction('auth', 'login'); ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn" style="width: 100%; padding: 10px; margin-top: 10px;">Login</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
