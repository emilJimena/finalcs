<?php 
// Import needed for navigation
$user = isset($user) ? $user : \App\Core\Auth::getCurrentUser();
$isAdmin = isset($isAdmin) ? $isAdmin : \App\Core\Auth::isAdmin();

if($user): 
?>
<div class="header">
    <h2>School Encoding Module</h2>
    <div class="header-right">
        <div class="user-info">
            <strong><?php echo htmlspecialchars($user['username']); ?></strong>
            <span><?php echo htmlspecialchars($user['account_type']); ?></span>
        </div>
        <a href="<?php echo \App\Core\Controller::urlToAction('auth', 'logout'); ?>" class="logout-btn">Logout</a>
    </div>
</div>

<div class="nav-menu">
    <ul>
        <li><a href="<?php echo \App\Core\Controller::urlToAction('home', 'index'); ?>">Home</a></li>
        <li><a href="<?php echo \App\Core\Controller::urlToAction('subject', 'list'); ?>">Subjects</a></li>
        <li><a href="<?php echo \App\Core\Controller::urlToAction('program', 'list'); ?>">Programs</a></li>
        <?php if($isAdmin): ?>
            <li><a href="<?php echo \App\Core\Controller::urlToAction('user', 'list'); ?>">Users</a></li>
        <?php endif; ?>
        <li><a href="<?php echo \App\Core\Controller::urlToAction('user', 'changePassword'); ?>">Change Password</a></li>
    </ul>
</div>
<?php endif; ?>
