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

  <?php if ($terms): ?>
    <div class="terms"><?php print $terms; ?></div>
  <?php endif; ?>

  <div class="content">
    <?php print $content; ?>
    
    <?php if($node->nid == 43): ?>
      <?php $customer_view = views_get_view('customer_table'); ?>
      <h3><?php echo l($customer_view->get_title()) ?></h3>
      <?php echo views_embed_view('customer_table', 'block_1'); ?>
    <?php endif; ?>
    
    <?php if ($node->nid == 55): ?>
      <?php if ($logged_in): ?>
        <!-- allow a logged in user to submit their own -->
        <?php
          $new_node = new stdClass();
          $new_node->type = 'deployment_project';
          module_load_include('inc', 'new_node', 'new_node.pages');
          $output = drupal_get_form('deployment_project_node_form', $new_node);
        ?>
        <h2>Add Your Deployment Project</h2>
        <div class="deployment-project-form"><?php echo $output ?></div>
      <?php else: ?>
        <p><?php echo l('Login', 'user/login') ?> to add your deployment project.</p>
      <?php endif ?>
    <?php endif ?>
    
    <?php if ($node->nid == 10 || $node->nid == 333): ?>
      <!-- show the system setup submissions from users -->
      <?php echo views_embed_view('system_setup', 'block_1'); ?>
      <?php if ($logged_in): ?>
        <!-- allow a logged in user to submit system setup -->
        <?php
          $new_node = new stdClass();
          $new_node->type = 'system_setup';
          module_load_include('inc', 'new_node', 'new_node.pages');
          $output = drupal_get_form('system_setup_node_form', $new_node);
        ?>
        <div class="system-setup-form"><?php echo $output ?></div>
      <?php else: ?>
        <p><?php echo l('Login', 'user/login') ?> to add your system configuration.</p>
      <?php endif ?>
    <?php endif ?>
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
