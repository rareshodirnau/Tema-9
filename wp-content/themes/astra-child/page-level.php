<?php
get_header();
$levels = get_terms('level');
foreach($levels as $level) {
  $engineers = new WP_Query(array(
    'post_type' => 'engineers',
    'post_per_page'=>-1,
    'taxonomy'=>'level',
    'term' => $level->slug,
  ));
  $link = get_term_link(intval($level->term_id),'level');
  echo "<h2><a href=\"{$link}\">{$level->name}</a></h2>";
  echo '<ul>';
  while ( $engineers->have_posts() ) {
    $engineers->the_post();
    $link = get_permalink($post->ID);
    $title = get_the_title();
    echo "<li><a href=\"{$link}\">{$title}</a></li>";
  }
  echo '</ul>';
}
get_footer();