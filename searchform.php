<?php $s = get_search_query(); ?>
<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>/">
    <input type="text" value="" placeholder="<?php _e("Search", 'aperitto'); ?>" name="s" class="s" />
    <input type="submit" class="submit search_submit" value="→" />
</form>
