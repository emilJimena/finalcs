<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/navigation.php'; ?>

<div class="container">
    <div class="content">
        <h1>Subjects</h1>
        <p class="page-subtitle">List of all subjects</p>

        <div class="action-bar">
            <a href="?controller=subject&action=new" class="btn">+ Add New Subject</a>
            <form method="GET" action="" class="search-box">
                <input type="hidden" name="controller" value="subject">
                <input type="hidden" name="action" value="list">
                <input type="text" name="search" placeholder="Search by code or title..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit">Search</button>
                <?php if(!empty($searchTerm)): ?>
                    <a href="?controller=subject&action=list" class="btn btn-secondary" style="padding: 10px 16px;">Clear</a>
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
                                    <a href="?controller=subject&action=edit&id=<?php echo $subject['subject_id']; ?>" class="btn-small">Edit</a>
                                    <a href="?controller=subject&action=delete&id=<?php echo $subject['subject_id']; ?>" class="btn-small btn-small-danger">Delete</a>
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
