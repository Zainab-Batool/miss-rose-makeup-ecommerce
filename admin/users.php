<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if user is admin
if (!isAdmin()) {
    header('Location: ../login.php');
    exit();
}

$message = '';

// Handle user actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'edit':
                $id = $_POST['id'];
                $name = $_POST['name'];
                $email = $_POST['email'];
                $is_admin = isset($_POST['is_admin']) ? 1 : 0;
                
                $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, is_admin = ? WHERE id = ?");
                if ($stmt->execute([$name, $email, $is_admin, $id])) {
                    $message = 'User updated successfully';
                }
                break;
                
            case 'delete':
                $id = $_POST['id'];
                // Don't allow deleting self
                if ($id != $_SESSION['user_id']) {
                    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
                    if ($stmt->execute([$id])) {
                        $message = 'User deleted successfully';
                    }
                } else {
                    $message = 'You cannot delete your own account';
                }
                break;
        }
    }
}

// Get all users
$users = $conn->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();

include '../includes/admin_header.php';
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1>Users Management</h1>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>

            <!-- Users Table -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <?php echo $user['is_admin'] ? 'Admin' : 'Customer'; ?>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" 
                                            onclick="editUser(<?php echo $user['id']; ?>)">
                                        Edit
                                    </button>
                                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                        <button class="btn btn-sm btn-danger" 
                                                onclick="deleteUser(<?php echo $user['id']; ?>)">
                                            Delete
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" id="edit_user_id">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>
                            <input type="checkbox" name="is_admin" id="edit_is_admin">
                            Admin Access
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>
