<?php

$format = get_post_format();
if (false === $format)
    $format = 'standard';
?>
    <?php
        if($format === 'video') {
            ?>
                <div class="s-stories-posts__post video-post animate__animated animate__zoomIn">
                    <a href="<?php the_permalink();?>" class="s-stories-posts__thumbnail">
                        <div class="video-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 72 72"><defs></defs><rect class="a" width="72" height="72" rx="36"/><path class="b" d="M-9710.969-6274.26a25.2,25.2,0,0,1-10.209-9.211,25.639,25.639,0,0,1-3.935-13.687,25.648,25.648,0,0,1,3.935-13.687,25.191,25.191,0,0,1,10.209-9.209l.791-.391,4.086,6.234-1.076.476a18.094,18.094,0,0,0-10.693,16.577,18.087,18.087,0,0,0,10.693,16.577l1.076.479-4.086,6.233Zm16.839-5.843,1.076-.479a18.083,18.083,0,0,0,10.692-16.577,18.09,18.09,0,0,0-10.692-16.577l-1.076-.476,4.083-6.234.793.391a25.18,25.18,0,0,1,10.212,9.209,25.631,25.631,0,0,1,3.93,13.687,25.628,25.628,0,0,1-3.93,13.688,25.168,25.168,0,0,1-10.212,9.211l-.793.388Z" transform="translate(9736.111 6333.157)"/><path class="b" d="M307.68,612.67l-7.04,4.69-1.66,1.11-3.3,2.2v-16l3.3,2.2,1.66,1.11Z" transform="translate(-263.68 -576.67)"/></svg>
                        </div>
                        <?php the_post_thumbnail()?>
                    </a>
            <?php
        } else {
            ?>
            <div class="s-stories-posts__post animate__animated animate__zoomIn">
                <a href="<?php the_permalink();?>" class="s-stories-posts__thumbnail">
                    <?php the_post_thumbnail(); ?>
                </a>
                <?php
            }
    ?>
    <div class="s-stories-posts__post-data">
        <h3 class="s-stories-posts__post-title">
            <a href="<?php the_permalink();?>"><?php the_title();?></a>
        </h3>
        <p class="s-stories-posts__excerpt">
            <?php the_excerpt();?>
        </p>
        <span class="s-stories-posts__post-date"><?php the_time("d F Y H:m:s");?></span>
    </div>
</div>