<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/navigation.php'; ?>

<div class="container">
    <div class="content" style="max-width: 600px;">
        <h1>Delete Subject</h1>
        <p class="page-subtitle">Confirm subject deletion</p>

        <?php if(!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif($subject): ?>
            <div style="background: #fff3cd; padding: 15px; border-radius: 3px; margin-bottom: 20px; border-left: 4px solid #ffc107;">
                <p><strong>Are you sure you want to delete this subject?</strong></p>
                <p style="margin-top: 10px; color: #7f8c8d;">
                    <strong>Code:</strong> <?php echo htmlspecialchars($subject['code']); ?><br>
                    <strong>Title:</strong> <?php echo htmlspecialchars($subject['title']); ?>
                </p>
                <p style="margin-top: 10px; color: #856404;">This action cannot be undone.</p>
            </div>

            <form method="POST" action="?controller=subject&action=delete&id=<?php echo $subjectId; ?>">
                <div class="btn-group">
                    <button type="submit" class="btn btn-danger">Delete Subject</button>
                    <a href="?controller=subject&action=list" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
