<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/navigation.php'; ?>

<div class="container">
    <div class="content" style="max-width: 600px;">
        <h1>Delete Program</h1>
        <p class="page-subtitle">Confirm program deletion</p>

        <?php if(!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif($program): ?>
            <div style="background: #fff3cd; padding: 15px; border-radius: 3px; margin-bottom: 20px; border-left: 4px solid #ffc107;">
                <p><strong>Are you sure you want to delete this program?</strong></p>
                <p style="margin-top: 10px; color: #7f8c8d;">
                    <strong>Code:</strong> <?php echo htmlspecialchars($program['code']); ?><br>
                    <strong>Title:</strong> <?php echo htmlspecialchars($program['title']); ?>
                </p>
                <p style="margin-top: 10px; color: #856404;">This action cannot be undone.</p>
            </div>

            <form method="POST" action="<?php echo \App\Core\Controller::urlToAction('program', 'delete', ['id' => $programId]); ?>">
                <div class="btn-group">
                    <button type="submit" class="btn btn-danger">Delete Program</button>
                    <a href="<?php echo \App\Core\Controller::urlToAction('program', 'list'); ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
