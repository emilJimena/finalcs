<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/navigation.php'; ?>

<div class="container">
    <div class="content" style="max-width: 600px;">
        <h1>Edit Subject</h1>
        <p class="page-subtitle">Update subject information</p>

        <?php if(!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="?controller=subject&action=edit&id=<?php echo $subjectId; ?>">
            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" value="<?php echo htmlspecialchars($code); ?>" required>
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
            </div>

            <div class="form-group">
                <label for="unit">Unit</label>
                <input type="number" id="unit" name="unit" value="<?php echo htmlspecialchars($unit); ?>" min="1" required>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn">Update Subject</button>
                <a href="?controller=subject&action=list" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
