<div id="login-wrapper">
    <?php include element('logged'); ?>
    <h2 class="float-left padding05"><a href="index">Home</a></h2>

    <form id="login-form" method="post">
        <br />
        <input type="submit" value="Save Users" class="float-right" /><br />
        <br />
        <fieldset <?php echo isset($arrValidate['newuser'])?'class="bg-alert"':''; ?>>
            <legend>new user</legend>

            <input id="create-newuser" name="data[user][newuser][create]" value="create" type="checkbox" class="float-right" <?php echo isset($arrUsers['newuser']['create'])?'checked="checked"':''; ?> />
            <label for="create-newuser" class="float-right">create&nbsp;</label>
            <div class="float-left">
                <label for="user-newuser">username</label><br />
                <input id="user-newuser" name="data[user][newuser][username]" type="text" value="<?php echo isset($arrUsers['newuser']['username'])?$arrUsers['newuser']['username']:''; ?>" /><br />
                <?php echo isset($arrValidate['newuser']['username'])?'<div class="color-alert">'.$arrValidate['newuser']['username'].'</div>':''; ?><br /><br />
            </div>
            <div class="float-left pad-left-10">
                <label for="roles-newuser">roles</label><br />
                <input id="roles-newuser" name="data[user][newuser][roles]" type="text" value="<?php echo isset($arrUsers['newuser']['roles'])?$arrUsers['newuser']['roles']:''; ?>" /><br />
                <?php echo isset($arrValidate['newuser']['roles'])?'<div class="color-alert">'.$arrValidate['newuser']['roles'].'</div>':''; ?><br /><br />
            </div>
            <div class="clear"></div>
            <div class="float-left">
                <label for="password-newuser">new password</label><br />
                <input id="password-newuser" name="data[user][newuser][password]" type="password" /><br />
                <?php echo isset($arrValidate['newuser']['password'])?'<div class="color-alert">'.$arrValidate['newuser']['password'].'</div>':''; ?><br /><br />
            </div>
            <div class="float-left pad-left-10">
                <label for="passwordconfirmation-newuser">confirm new password</label><br />
                <input id="passwordconfirmation-newuser" name="data[user][newuser][passwordconfirmation]" type="password" /><br />
                <?php echo isset($arrValidate['newuser']['passwordconfirmation'])?'<div class="color-alert">'.$arrValidate['newuser']['passwordconfirmation'].'</div>':''; ?><br /><br />
            </div>
            <div class="clear"></div>
        </fieldset>
        <br />

        <?php if ( isset( $arrUsers['newuser'] ) ) { unset( $arrUsers['newuser'] ); } ?>
        <?php foreach ( $arrUsers as $uk=>$user ): ?>
            <fieldset <?php echo isset($arrValidate[$uk])?'class="bg-alert"':''; ?>>
                <legend> <?php echo $user['username']; ?></legend>

                <input id="delete-newuser" name="data[user][<?php echo $user['username']; ?>][delete]" value="delete" type="checkbox" class="float-right" />
                <label for="delete-newuser" class="float-right">delete&nbsp;</label>
                <div class="float-left">
                    <label for="user-<?php echo $user['username']; ?>">username</label><br />
                    <input id="user-<?php echo $user['username']; ?>" name="data[user][<?php echo $user['username']; ?>][username]" type="text" value="<?php echo $user['username']; ?>" /><br />
                    <?php echo isset($arrValidate[$uk]['username'])?'<div class="color-alert pos-abs ov-hidden">'.$arrValidate[$uk]['username'].'</div>':''; ?><br /><br />
                </div>
                <div class="float-left pad-left-10">
                    <label for="roles-<?php echo $user['username']; ?>">roles</label><br />
                    <input id="roles-<?php echo $user['username']; ?>" name="data[user][<?php echo $user['username']; ?>][roles]" type="text" value="<?php echo $user['roles']; ?>" /><br />
                    <?php echo isset($arrValidate[$uk]['roles'])?'<div class="color-alert pos-abs ov-hidden">'.$arrValidate[$uk]['roles'].'</div>':''; ?><br /><br />
                </div>
                <div class="clear"></div>
                <div class="float-left">
                    <label for="password-<?php echo $user['username']; ?>">new password</label><br />
                    <input id="password-<?php echo $user['username']; ?>" name="data[user][<?php echo $user['username']; ?>][password]" type="password" /><br />
                    <?php echo isset($arrValidate[$uk]['password'])?'<div class="color-alert pos-abs ov-hidden">'.$arrValidate[$uk]['password'].'</div>':''; ?><br /><br />
                </div>
                <div class="float-left pad-left-10">
                    <label for="passwordconfirmation-<?php echo $user['username']; ?>">confirm new password</label><br />
                    <input id="passwordconfirmation-<?php echo $user['username']; ?>" name="data[user][<?php echo $user['username']; ?>][passwordconfirmation]" type="password" /><br />
                    <?php echo isset($arrValidate[$uk]['passwordconfirmation'])?'<div class="color-alert pos-abs ov-hidden">'.$arrValidate[$uk]['passwordconfirmation'].'</div>':''; ?><br /><br />
                </div>
                <div class="clear"></div>
            </fieldset>
            <br />
        <?php endforeach; ?>
        <input type="submit" value="Save Users" class="float-right" /><br />
    </form>
</div>

<?php
////debug($arrUsers);
//debug($userRoles);
?>
