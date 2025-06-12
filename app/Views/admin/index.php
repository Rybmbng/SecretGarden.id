<?php echo view('adminpartial/header'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Admin Dashboard</h1>
            <p>Welcome to the admin dashboard. Here you can manage your application settings and content.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">Add, edit, or delete users from the system.</p>
                    <a href="<?= site_url('admin/users') ?>" class="btn btn-primary">Manage Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Products</h5>
                    <p class="card-text">Add, edit, or delete products in the inventory.</p>
                    <a href="<?= site_url('admin/products') ?>" class="btn btn-primary">Manage Products</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title           ">Settings</h5>
                    <p class="card-text">Configure application settings and preferences.</p>
                    <a href="<?= site_url('admin/settings') ?>" class="btn btn-primary">Settings</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h2>Recent Activity</h2>
            <ul class="list-group">
                <li class="list-group-item">User John Doe created a new account.</li>
                <li class="list-group-item">Product "Luxury Candle" was added to the inventory.</li>
                <li class="list-group-item">Settings were updated by Admin.</li>
            </ul>
        </div>
    </div>
</div>
</div>
<?php echo view('adminpartial/footer'); ?>