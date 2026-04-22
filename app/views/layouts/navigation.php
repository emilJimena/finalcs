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
        <a href="?controller=auth&action=logout" class="logout-btn">Logout</a>
    </div>
</div>

<div class="nav-menu">
    <ul>
        <li><a href="?controller=home&action=index">Home</a></li>
        <li><a href="?controller=subject&action=list">Subjects</a></li>
        <li><a href="?controller=program&action=list">Programs</a></li>
        <?php if($isAdmin): ?>
            <li><a href="?controller=user&action=list">Users</a></li>
        <?php endif; ?>
        <li><a href="?controller=user&action=changePassword">Change Password</a></li>
    </ul>
</div>
<?php endif; ?>
