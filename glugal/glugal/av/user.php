<div id="login-wrapper">
    <?php include element('logged'); ?>
    <h2 class="float-left padding05"><a href="index">Home</a></h2>

    <form id="login-form" method="post">
        <br />
        <label for="currentpassword">current password</label><br />
        <input id="currentpassword" name="data[user][currentpassword]" type="password" /><br /><br />

        <label for="newpassword">new password</label><br />
        <input id="newpassword" name="data[user][newpassword]" type="password" /><br /><br />

        <label for="confirmpassword">confirm new password</label><br />
        <input id="confirmpassword" name="data[user][confirmpassword]" type="password" /><br /><br />

        <input type="submit" value="Change password" /><br />
    </form>
</div>
