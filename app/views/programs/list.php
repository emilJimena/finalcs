<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/navigation.php'; ?>

<div class="container">
    <div class="content">
        <h1>Programs</h1>
        <p class="page-subtitle">List of all programs</p>

        <div class="action-bar">
            <a href="<?php echo \App\Core\Controller::urlToAction('program', 'new'); ?>" class="btn">+ Add New Program</a>
            <form method="GET" action="<?php echo \App\Core\Controller::urlToAction('program', 'list'); ?>" class="search-box">
                <input type="text" name="search" placeholder="Search by code or title..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit">Search</button>
                <?php if(!empty($searchTerm)): ?>
                    <a href="<?php echo \App\Core\Controller::urlToAction('program', 'list'); ?>" class="btn btn-secondary" style="padding: 10px 16px;">Clear</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if(empty($programs)): ?>
            <div class="no-results">
                <p><?php echo !empty($searchTerm) ? 'No programs found matching your search.' : 'No programs found.'; ?></p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Years</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($programs as $program): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($program['code']); ?></td>
                            <td><?php echo htmlspecialchars($program['title']); ?></td>
                            <td><?php echo htmlspecialchars($program['years']); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo \App\Core\Controller::urlToAction('program', 'edit', ['id' => $program['program_id']]); ?>" class="btn-small">Edit</a>
                                    <a href="<?php echo \App\Core\Controller::urlToAction('program', 'delete', ['id' => $program['program_id']]); ?>" class="btn-small btn-small-danger">Delete</a>
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
