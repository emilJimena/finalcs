<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/navigation.php'; ?>

<div class="container">
    <div class="content">
        <h1>Subjects</h1>
        <p class="page-subtitle">List of all subjects</p>

        <div class="action-bar">
            <a href="<?php echo \App\Core\Controller::urlToAction('subject', 'new'); ?>" class="btn">+ Add New Subject</a>
            <form method="GET" action="<?php echo \App\Core\Controller::urlToAction('subject', 'list'); ?>" class="search-box">
                <input type="text" name="search" placeholder="Search by code or title..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit">Search</button>
                <?php if(!empty($searchTerm)): ?>
                    <a href="<?php echo \App\Core\Controller::urlToAction('subject', 'list'); ?>" class="btn btn-secondary" style="padding: 10px 16px;">Clear</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if(empty($subjects)): ?>
            <div class="no-results">
                <p><?php echo !empty($searchTerm) ? 'No subjects found matching your search.' : 'No subjects found.'; ?></p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Unit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($subjects as $subject): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($subject['code']); ?></td>
                            <td><?php echo htmlspecialchars($subject['title']); ?></td>
                            <td><?php echo htmlspecialchars($subject['unit']); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo \App\Core\Controller::urlToAction('subject', 'edit', ['id' => $subject['subject_id']]); ?>" class="btn-small">Edit</a>
                                    <a href="<?php echo \App\Core\Controller::urlToAction('subject', 'delete', ['id' => $subject['subject_id']]); ?>" class="btn-small btn-small-danger">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
