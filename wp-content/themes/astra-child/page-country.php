<?php
get_header();
$countries = get_terms('country');
foreach($countries as $country) {
  $software = new WP_Query(array(
    'post_type' => 'software',
    'post_per_page'=>-1,
    'taxonomy'=>'country',
    'term' => $country->slug,
  ));
  $link = get_term_link(intval($country->term_id),'country');
  echo "<h2><a href=\"{$link}\">{$country->name}</a></h2>";
  echo '<ul>';
  while ( $software->have_posts() ) {
    $software->the_post();
    $link = get_permalink($post->ID);
    $title = get_the_title();
    echo "<li><a href=\"{$link}\">{$title}</a></li>";
  }
  echo '</ul>';
}
get_footer();