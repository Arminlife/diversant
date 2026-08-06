<form class="donate">
    <script>
        jQuery( document ).ready(function($){
            $(".control").click(function(){
                if ( $(this).hasClass("period") ){
                    $("input[name='recurring']").val($(this).data('recurring'));
                    $(".period").removeClass("checked");
                    $(this).addClass("checked");
                } else if ( $(this).hasClass("amount") ){
                    $("input[name='amount']").val($(this).data('amount'));
                    $(".amount").removeClass("checked");
                    $(this).addClass("checked");
                }
            });
            $("input[name='other_amount']").on('focus' , function(){
                $(".amount").removeClass("checked");
                if ( $(this).val() != "" ){
                    $("input[name='amount']").val($(this).val());
                }
                $("input[name='other_amount']").on('input' , function(){
                    if ( $(this).val() != "" ){
                        $("input[name='amount']").val($(this).val());
                    }
                })
            })
        })
    </script>
    <p class="caption"><?php esc_html_e( 'Every day our team exposes corruption and investigates resonant crimes, but we need your support. Each of your hryvnia can be our new investigation.', 'slidstvo-info-theme' ); ?></p>
    <div class="controls">
        <div class="period control once_control" data-recurring="false">
            <?php esc_html_e( 'One time', 'slidstvo-info-theme' ); ?>
        </div>
        <div class="period control mothly_control" data-recurring="true">
            <?php esc_html_e( 'Monthly', 'slidstvo-info-theme' ); ?>
        </div>
        <div class="amount control" data-amount="50">
            <?php esc_html_e( '50 UAH', 'slidstvo-info-theme' ); ?>
        </div>
        <div class="amount control"  data-amount="200">
            <?php esc_html_e( '200 UAH', 'slidstvo-info-theme' ); ?>
        </div>
        <div class="amount control" data-amount="500">
            <?php esc_html_e( '500 UAH', 'slidstvo-info-theme' ); ?>
        </div>
        <div>
            <input type="number" name="other_amount" value="" placeholder="<?php esc_html_e( 'other', 'slidstvo-info-theme' ); ?>">
        </div>
        <div class="first_name">
            <input type="text" name="first_name" value="" placeholder="<?php esc_html_e( 'first name', 'slidstvo-info-theme' ); ?>">
        </div>
        <div class="last_name">
            <input type="text" name="last_name" value="" placeholder="<?php esc_html_e( 'last name', 'slidstvo-info-theme' ); ?>">
        </div>
    </div>
    <div id="form_errors">

    </div>
    <input type="button" id="submit_donation" name="" value="<?php esc_html_e( 'donate', 'slidstvo-info-theme' ); ?>" onclick="generateOrder();" class="btn btn-primary donate-btn">
    <input type="hidden" name="amount" value="">
    <input type="hidden" name="recurring" value="">
</form>
