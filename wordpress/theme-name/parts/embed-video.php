<?php $video = get_post_meta( get_the_ID(), 'wpcf-video-url', true ); ?>
<script>
jQuery(document).ready(function($) {
    // Find all YouTube videos
    var $allVideos = $("iframe[src^='//www.youtube.com']"),

        // The element that is fluid width
        $fluidEl = $("body");

    // Figure out and save aspect ratio for each video
    $allVideos.each(function() {

        $(this)
            .data('aspectRatio', this.height / this.width)

            // and remove the hard coded width/height
            .removeAttr('height')
            .removeAttr('width');

    });

    // When the window is resized
    $(window).resize(function() {

        var newWidth = $fluidEl.width();

        // Resize all videos according to their own aspect ratio
        $allVideos.each(function() {

            var $el = $(this);
            $el
                .width(newWidth)
                .height(newWidth * $el.data('aspectRatio'));

        });

        // Kick off one resize to fix all videos on page load
    }).resize();
})
</script>
<?php if ( !empty($video) ) : ?>

<div class="player">
    <?php
    $ytarray = explode( "/", $video );
    $ytendstring = end( $ytarray );
    $ytendarray = explode( "?v=", $ytendstring );
    $ytendstring = end( $ytendarray );
    $ytendarray = explode( "&", $ytendstring );
    $ytcode = $ytendarray[0];
    echo "<iframe width=\"420\" height=\"315\" src=\"https://www.youtube.com/embed/$ytcode\" frameborder=\"0\" allowfullscreen></iframe>";
     ?>
</div>


<?php endif; ?>
