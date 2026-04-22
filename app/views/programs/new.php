<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/navigation.php'; ?>

<div class="container">
    <div class="content" style="max-width: 600px;">
        <h1>Add New Program</h1>
        <p class="page-subtitle">Create a new program</p>

        <?php if(!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo \App\Core\Controller::urlToAction('program', 'new'); ?>">
            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" value="<?php echo htmlspecialchars($code); ?>" required>
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
            </div>

            <div class="form-group">
                <label for="years">Years</label>
                <input type="number" id="years" name="years" value="<?php echo htmlspecialchars($years); ?>" min="1" required>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn">Create Program</button>
                <a href="<?php echo \App\Core\Controller::urlToAction('program', 'list'); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
