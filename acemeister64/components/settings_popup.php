<div class="popup" id="account-settings">
    <h2>Account Settings</h2>
    <form id="profile-form">
      <input type="hidden" name="page" value="main" />
      <input type="hidden" name="command" value="update_profile" />
      <label for="new_email">Email</label>
      <input id="new_email" name="new_email" type="email" value="<?php echo htmlspecialchars($currentUser['email'] ?? ''); ?>" required />
      <label for="new_password">New Password</label>
      <input id="new_password" name="new_password" type="password" placeholder="Leave blank to keep password" />
      <label for="current_password">Current Password</label>
      <input id="current_password" name="current_password" type="password" placeholder="Required to save" required />
      <button type="submit">Save Profile</button>
    </form>
    <button id="delete-account-button">Delete Account</button>
    <form id="logout-form" method="post" action="controller.php">
      <input type="hidden" name="page" value="main" />
      <input type="hidden" name="command" value="logout" />
      <input type="submit" value="Log Out" />
    </form>
    <div id="account-message"></div>
  </div>