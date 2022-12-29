<form class="d-flex search" role="search" method="get" action="<?php echo esc_url( home_url( '/shop' ) ); ?>">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="s" value="<?= get_search_query() ?>" >
    <input type="hidden" value="product" name="post_type" id="post_type" />
    <button class="btn btn-success" class="search_button" type="submit">Search</button>
</form>

