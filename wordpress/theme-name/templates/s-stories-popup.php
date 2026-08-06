<div class="s-stories__notification">
    <div class="notification-inner">
        <img src="<?php echo get_template_directory_uri()?>/img/Suricata.svg" alt="Surikat">
        <button class="button-tell-us"data-popup="tell-us">РОЗПОВІСТИ</button>
    </div>
</div>

<div class="tell-your-story-popup__popup" data-popup="tell-us">
    <div class="tell-your-story-popup__inner animate__animated animate__zoomIn">
        <button class="tell-your-story-popup__close"></button>
        <div class="form-wrap">
            <div class="tell-your-story-popup__headlines">
                <h3>Розкажи свою історію</h3>
                <p>Боротьби з корупцією</p>
            </div>
            <?php echo do_shortcode('[contact-form-7 id="16087" title="Tell your story"]')?>
        </div>
    </div>
</div>