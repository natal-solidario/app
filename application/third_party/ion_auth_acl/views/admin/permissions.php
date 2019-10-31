<h1>Manage Permissions</h1>

<ul>
    <li><?php echo anchor('/admin/add_permission', 'Add Permission'); ?></li>
    <li><?php echo anchor('/admin/manage', 'Back to admin'); ?></li>
</ul>

<table>
    <thead>
        <tr>
            <th>Key</th>
            <th>Name</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($permissions as $permission) : ?>
        <tr>
            <td><?php echo $permission['key']; ?></td>
            <td><?php echo $permission['name']; ?></td>
            <td>
                <a href="<?php echo site_url("/admin/update_permission/". $permission['id']); ?>">Edit</a>
                <?php /*<a href="<?php echo site_url("/admin/delete_permission/". $permission['id']); ?>">Delete</a>*/ ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>