<?php
$ajax_url = admin_url( 'admin-ajax.php' );
?>
<div class="dv-search-wrap">
  <form
    role="search"
    method="get"
    class="header-search"
    id="dv-search-form"
    action="<?php echo esc_url( home_url( '/' ) ); ?>"
    data-live-search-url="<?php echo esc_url( $ajax_url ); ?>"
  >
    <input type="hidden" name="post_type" value="product">
    <input
      type="search"
      name="s"
      id="dv-search-input"
      class="dv-search-input"
      placeholder="Поиск по артикулу, марке, модели..."
      value="<?php echo esc_attr( get_search_query() ); ?>"
      autocomplete="off"
    >
    <button type="submit" class="dv-search-submit" aria-label="Найти">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>
    </button>
  </form>

  <div id="dv-live-results" class="dv-live-results"></div>
</div>
