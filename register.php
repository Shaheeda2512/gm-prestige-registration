<?php 
// register.php
$page_title = 'Register';
include ('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    
    // Validate user code
    if (empty($_POST['user_code'])) {
        $errors[] = 'You forgot to enter your user code.';
    } else {
        $uc = trim($_POST['user_code']);
    }
    
    // Validate user name
    if (empty($_POST['user_name'])) {
        $errors[] = 'You forgot to enter your HP name.';
    } else {
        $un = trim($_POST['user_name']);
    }
    
    // Validate SM name
    if (empty($_POST['sm_name'])) {
        $errors[] = 'You forgot to enter your SM name.';
    } else {
        $sn = trim($_POST['sm_name']);
    }
    
    if (empty($errors)) {
        // Corrected file path
        require ('mysqli_connect.php');
        
        // Secure SQL Query with Prepared Statement
        $stmt = mysqli_prepare($dbc, "INSERT INTO users (user_code, user_name, sm_name) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sss', $uc, $un, $sn);
        mysqli_stmt_execute($stmt);
        
        if (mysqli_stmt_affected_rows($stmt) == 1) {
            echo '<h1>Thank you for registering!</h1>
                  <p>You are now registered!</p>';
            
            // Display the event poster after successful registration
            echo '<h2>Event Poster</h2>
            <div style="text-align: center;">
            <img src="poster.jpg" alt="Event Poster" style="max-width: 50%; width: auto; height: auto;">
            </div>';

        } else {
            echo '<h1>System Error</h1>
                  <p class="error">You could not be registered due to a system error.</p>';
            // Log the error instead of showing it to the user
            error_log(mysqli_error($dbc));
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($dbc);
        include ('includes/footer.html');
        exit();
    } else {
        echo '<h1>Error!</h1>
              <div class="error">
                  <p>The following error(s) occurred:<br />';
        foreach ($errors as $msg) {
            echo " - $msg<br />\n";
        }
        echo '</p><p>Please try again.</p>
              </div>';
    }
}
?>
<!-- Registration Form -->
<h1>Register for the Event</h1>
<form action="register.php" method="post">
    <p>
        HP Code:
        <input type="text" name="user_code" size="15" maxlength="20" value="<?php echo isset($_POST['user_code']) ? htmlspecialchars($_POST['user_code'], ENT_QUOTES, 'UTF-8') : ''; ?>" required />
    </p>
    <p>
        HP Name:
        <input type="text" name="user_name" size="15" maxlength="40" value="<?php echo isset($_POST['user_name']) ? htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8') : ''; ?>" required />
    </p>
    <p>
        SM Name:
        <select name="sm_name" required>
            <option value="">Select SM Name</option>
            <option value="SM SAIFULRIJAL" <?php echo (isset($_POST['sm_name']) && $_POST['sm_name'] === 'SM SAIFULRIJAL') ? 'selected' : ''; ?>>SM SAIFULRIJAL</option>
            <option value="SM HAMID" <?php echo (isset($_POST['sm_name']) && $_POST['sm_name'] === 'SM HAMID') ? 'selected' : ''; ?>>SM HAMID</option>
            <option value="SM SYAHRUL AIDI" <?php echo (isset($_POST['sm_name']) && $_POST['sm_name'] === 'SM SYAHRUL AIDI') ? 'selected' : ''; ?>>SM SYAHRUL AIDI</option>
            <option value="SM MUNIRAH" <?php echo (isset($_POST['sm_name']) && $_POST['sm_name'] === 'SM MUNIRAH') ? 'selected' : ''; ?>>SM MUNIRAH</option>
            <option value="SM BARIYAH" <?php echo (isset($_POST['sm_name']) && $_POST['sm_name'] === 'SM BARIYAH') ? 'selected' : ''; ?>>SM BARIYAH</option>
            <option value="SM FAUZA" <?php echo (isset($_POST['sm_name']) && $_POST['sm_name'] === 'SM FAUZA') ? 'selected' : ''; ?>>SM FAUZA</option>
            <option value="SM SAKINAH" <?php echo (isset($_POST['sm_name']) && $_POST['sm_name'] === 'SM SAKINAH') ? 'selected' : ''; ?>>SM SAKINAH</option>
        </select>
    </p>
    <p>
        <input type="submit" name="submit" value="Register" />
    </p>
</form>
<?php include ('includes/footer.html'); ?>
