    <div id="logged">
        <?php if ( isset($gAuth)  && $gAuth ): ?>
            <?php if ( !empty( $gUser['username'] ) ): ?>
                <a href="user"><?php echo $gUser['username']; ?></a>
                | <a href="index/logout">Logout</a>
                <?php else: ?>
                <a href="index">Login</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
