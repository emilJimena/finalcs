<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../layouts/navigation.php'; ?>

<div class="container">
    <div class="content">
        <h1>Users</h1>
        <p class="page-subtitle">Manage system users (Admin only)</p>

        <div class="action-bar">
            <a href="<?php echo \App\Core\Controller::urlToAction('user', 'new'); ?>" class="btn">+ Add New User</a>
        </div>

        <?php if(empty($users)): ?>
            <div class="no-results">
                <p>No users found.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Account Type</th>
                        <th>Created On</th>
                        <th>Updated On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $u): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($u['username']); ?></td>
                            <td><?php echo htmlspecialchars($u['account_type']); ?></td>
                            <td><?php echo $u['created_on'] ? date('M d, Y', strtotime($u['created_on'])) : '-'; ?></td>
                            <td><?php echo $u['updated_on'] ? date('M d, Y', strtotime($u['updated_on'])) : '-'; ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo \App\Core\Controller::urlToAction('user', 'edit', ['id' => $u['id']]); ?>" class="btn-small">Edit</a>
                                    <a href="<?php echo \App\Core\Controller::urlToAction('user', 'delete', ['id' => $u['id']]); ?>" class="btn-small btn-small-danger">Delete</a>
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
