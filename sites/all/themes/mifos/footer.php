    <div id="footer"><div id="footer-inner" class="region region-footer">

      <?php if ($footer_message): ?>
        <div id="footer-message"><?php print $footer_message; ?></div>
      <?php endif; ?>
      
      <div id="gray-footer">
        <?php print $footer; ?>
        
        <p id="email-signup">Sign up for our <a href="/node/526">e-mail list</a> For updates. </p>
      </div> <!-- gray-footer -->
      
      <div id="footer-extras">
        <p id="footer-logo"><a href="http://www.grameenfoundation.org"><img src="<?php echo base_path() . path_to_theme() ?>/images/logo_grameen.png" /></a></p>

        <div id="copyright">
          <?php print $footer_links ?>
          <p>Copyright &copy; <?php echo date('Y') ?> Grameen Foundation. <a href="http://www.grameenfoundation.org/privacy-policy/">PRIVACY POLICY</a></p>
        </div>

        <p id="donate-text">Help support innovations that help end the cycle of poverty.</p>
        <p id="donate-button"><a href="https://secure3.convio.net/gfusa/site/Donation2?idb=754735032&df_id=1500&1500.donation=form1"><img src="<?php echo base_path() . path_to_theme() ?>/images/btn_donate.png" alt="Donate Now"></a></p>
      </div> <!-- footer-extras -->

    </div></div> <!-- /#footer-inner, /#footer -->
