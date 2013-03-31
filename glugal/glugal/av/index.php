<div id="login-wrapper">
    <?php include element('logged'); ?>
    <h2 class="float-left padding05"><a href="index">Home</a></h2>
    <?php /*if ( !isset($_SESSION['gUser']) || !$_SESSION['gUser'] ):*/ ?>
    <?php if ( empty($gUser['username']) ): ?>
    <form id="login-form" method="post">
        <br />
        <label for="username">username</label><br />
        <input id="username" name="data[login][username]" type="text" /><br /><br />

        <label for="password">password</label><br />
        <input id="password" name="data[login][password]" type="password" /><br /><br />

        <input type="submit" value="Login" /><br />
    </form>
    <?php else: ?>
    <div class="login-box">
        <br /><br /><br /><br /><br />
        <a class="font-bold display-block align-center" href="galleries">GluGallery Backend</a>
        <?php if ( gHasRole( 'admin' ) ): ?>
            <br /><a class="font-bold display-block align-center" href="users">User Management</a>
            <br /><a class="font-bold display-block align-center" href="perms">Perms Management</a>
        <?php endif; ?>
        <br /><br /><br /><br /><br />
    </div>
    <?php endif; ?>
</div>
