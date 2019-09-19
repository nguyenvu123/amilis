 </div>
</div> <!-- #siteWrapper -->
<!-- <a href="#siteWrapper" class="back-to-top scroll"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/arrow-top.svg") ?></a> -->

<footer class="site-footer">
    <div class="top-footer">
        <div class="container container-wide ">
            <div class="row">
                <div class="col-sm-3 logo-footer">
                    <img class="logo" src="<?php bloginfo('template_url');?>/assets/images/main-logo.svg" height="64" alt="<?php bloginfo('name'); ?>">
                    <div class="h-space-20"></div>
                    <div class="include-icon-share">
                         <a href="https://www.youtube.com/channel/UCOanvcTvuC4VeyMP3kQn3IA">
                            <img src="<?php bloginfo('template_url');?>/assets/images/youtube.svg" height="26" alt="YouTube">
                        </a>
                        <a href="https://www.facebook.com/AmelisServices">
                            <img src="<?php bloginfo('template_url');?>/assets/images/facebook.svg" height="26" alt="Facebook">
                        </a>
                        <a href="https://twitter.com/amelisservices">
                            <img src="<?php bloginfo('template_url');?>/assets/images/twitter.svg" height="26" alt="Twitter">
                        </a>
                        <a href="https://www.linkedin.com/company/amelis-services/">
                            <img src="<?php bloginfo('template_url');?>/assets/images/linkedin.svg" height="26" alt="LinkedIn">
                        </a>
                    </div>
                       <p> &copy; <?php echo date("Y", time()); ?> Amelis - Tous droits réservés</p>
                </div>
                <div class="col-sm-9 right-menu-footer">
                    <?php dynamic_sidebar("Footer Widget"); ?>
                </div>
                
            </div>
        </div>
    </div>

    <div class="bottom-footer">
        <div class="container">
            <div class="row">
                <div class="col-9">
                     <?php dynamic_sidebar("Footer Widget Legal"); ?>
                </div>
                <div class="col-sm-3 text-right social-media">
              
                    <div class="h-space-30"></div>

                    <div class="footer-logos">
                        <a href="http://www.entreprises.gouv.fr/services-a-la-personne">
                           <img src="<?php bloginfo('template_url');?>/assets/images/services-a-la-personne.png" height="74" alt="<?php bloginfo('name'); ?>" style="width:59px; height: auto">
                        </a>
                        <a href="http://fr.sodexo.com/frfr/default.aspx">
                            <img src="<?php bloginfo('template_url');?>/assets/images/sodexo.svg" height="38" alt="Sodexo" style="width:85px; height: 38px">
                        </a>
                        <a href="https://www.bureauveritas.fr/besoin/certification-qualisap">
                            <img src="<?php bloginfo('template_url');?>/assets/images/QUALISAP-LOGO.png"  alt="Qualisap" style="width:59px">
                        </a>
                    </div>
                </div>
            </div>
        </div>
          
    </div>
</footer>

<div class="xs-sticky-nav visible-xs">
    <div class="container">
        <div class="row">
            <div class="col-xs-4 text-center">
                <a href="/nos-agences">
                    <img src="<?php bloginfo('template_url');?>/assets/images/icon-pin.svg" alt="Nos Agences" height="24">
                    <span>Nos Agences</span>
                </a>
            </div>
            <div class="col-xs-4 text-center">
                <a href="tel:0172680201">
                    <img src="<?php bloginfo('template_url');?>/assets/images/icon-call.svg" alt="Appel" height="24">
                    <span>Appel</span>
                </a>
            </div>
            <div class="col-xs-4 text-center">
                <a href="/demander-un-devis-gratuit">
                    <img src="<?php bloginfo('template_url');?>/assets/images/icon-devis.svg" alt="Devis Gratuit" height="24">
                    <span>Devis Gratuit</span>
                </a>
            </div>
        </div>
    </div>
</div>
<?php wp_footer(); ?>


</body>
</html>