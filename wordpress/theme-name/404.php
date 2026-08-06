<?php get_header(); ?>
    <style media="screen">
        html, body{
            min-height: 100%;
        }
        body{
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }
        main{
            flex-grow: 1;
        }
        .page-404 h1{
            font-size: 5em;
        }
        .page-404 h1,.page-404 h2{
            font-family: monospace, sans-serif;
        }
        .page-404{
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
            text-align: center;
        }
    </style>
	<div class="container page-404">
        <div>
            <h1>404</h1>
            <h2><?php esc_html_e( 'Page not found', 'slidstvo-info-theme' ); ?></h2>
        </div>
	</div>

<?php get_footer(); ?>
