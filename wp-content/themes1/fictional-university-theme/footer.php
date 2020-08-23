<footer class="site-footer">
    <div class="site-footer__inner container container--narrow">
        <div class="group">
        <div class="site-footer__col-one">
            <h1 class="school-logo-text school-logo-text--alt-color">
            <a href="<?php site_url('')?>"><strong>Nick</strong> Reyno</a>
            </h1>
            <p><a target="_blank" rel="noopener" class="site-footer__link" href="https://nickreyno.com">www.nickreyno.com</a></p>
        </div>

        <div class="site-footer__col-two-three-group">
            <div class="site-footer__col-two">
            <h3 class="headline headline--small">Explore</h3>
            <nav class="nav-list">
                <ul>
                    <?php wp_nav_menu(array(
                        'theme_location'=>'footer_menu_location_one'
                    ));
                    ?>
                </ul>
            </nav>
            </div>

            <div class="site-footer__col-three">
            <h3 class="headline headline--small">Learn</h3>
            <nav class="nav-list">
                <ul>
                    <?php
                wp_nav_menu(array(
                        'theme_location'=>'footer_menu_location_two'
                    ));
                    ?>
                </ul>
            </nav>
            </div>
        </div>

        <div class="site-footer__col-four">
            <h3 class="headline headline--small">Connect With Me</h3>
            <nav>
            <ul class="min-list social-icons-list group">
                <li>
                    <a target="_blank" rel="noopener" href="https://github.com/nickreyno" class="social-color-github"><i class="fa fa-github" aria-hidden="true"></i></a>
                </li>
                <li>
                    <a target="_blank" rel="noopener" href="https://www.linkedin.com/in/nickreyno/" class="social-color-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                </li>
                <li>
                    <a target="_blank" rel="noopener" href="https://twitter.com/nickreyno" class="social-color-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </li>
                <li>
                <a target="_blank" rel="noopener" href="https://www.instagram.com/nickrenoe/" class="social-color-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                </li>
                <li>
                <a target="_blank" rel="noopener" href="https://open.spotify.com/user/12159702639" class="social-color-github"><i class="fa fa-spotify" aria-hidden="true"></i></a>
                </li>
            </ul>
            </nav>
        </div>
        </div>
    </div>
    </footer>
<?php wp_footer();
?>
</body>
</html>