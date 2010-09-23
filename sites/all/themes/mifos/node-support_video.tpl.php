<?php
// $Id: node.tpl.php,v 1.4.2.1 2009/05/12 18:41:54 johnalbin Exp $

/**
 * @file node.tpl.php
 *
 * Theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: Node body or teaser depending on $teaser flag.
 * - $picture: The authors picture of the node output from
 *   theme_user_picture().
 * - $date: Formatted creation date (use $created to reformat with
 *   format_date()).
 * - $links: Themed links like "Read more", "Add new comment", etc. output
 *   from theme_links().
 * - $name: Themed username of node author output from theme_user().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $submitted: themed submission information output from
 *   theme_node_submitted().
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $teaser: Flag for the teaser state.
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 */
 
 $tags = array();
 foreach ($node->taxonomy as $tag_object) {
  $tags[] = l($tag_object->name, taxonomy_term_path($tag_object));
 }
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"><div class="node-inner">

  <?php print $picture; ?>

  <?php if (!$page): ?>
    <h2 class="title">
      <a href="<?php print $node_url; ?>" title="<?php print $title ?>"><?php print $title; ?></a>
    </h2>
  <?php endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <?php if (count($tags) > 0): ?>
    <div class="meta">
      <div class="terms"><?php print implode(', ', $tags) ?></div>
    </div>
  <?php endif; ?>

  <div class="content">
    <?php
      // embed video
      if ($node->field_video_embed[0]['embed']) {
        $system_types = _content_type_info();
        $field = $system_types['fields']['field_video_embed'];
        print theme('emvideo_video_video', $field, $node->field_video_embed[0], 'emvideo_embed', $node);            
      }
    ?>
    
    <?php echo $node->content['fivestar_widget']['#value'] ?>
    
    <?php echo $node->content['body']['#value'] ?>
  </div>
  
  <?php if ($submitted || $comment): ?>
    <div class="meta-comments">
      <?php if ($comment): ?>
        <div class="comment-count"><?php echo $comment_count ?> Comment<?php echo $comment_count == 1 ? '' : 's' ?></div>
      <?php endif ?>
      
      <?php if ($submitted): ?>
        <div class="submitted">
          Posted by <?php echo $name ?> on <?php echo date('F d, Y \a\t g:ia', $created) ?>
        </div>
      <?php endif ?>
    </div>
  <?php endif; ?>

  <?php print $links; ?>

</div></div> <!-- /node-inner, /node -->

<?php if ($node->field_subtitle && count($node->field_subtitle) > 0): ?>
  <!-- show the subtitle, if there is one -->
  <div id="subtitle" style="display:none;">
    <h2><?php print $node->field_subtitle[0]['value']; ?></h2>
  </div> <!-- subtitle -->
<?php endif ?>
