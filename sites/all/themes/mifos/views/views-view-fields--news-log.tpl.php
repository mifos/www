<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 * 
 * KRP: News entry is formatted per instructions at http://mifosforge.jira.com/browse/MIFOSWEB-26.
 * See <code>sites/all/themes/mifos-fresh.css</code> for layout.
 */
?>
<?php
  //dsm($fields);
  
  // the raw field is a Unix timestamp.
  $date = new DateTime("@{$fields['created']->raw}");
?>
<div class="news-entry">
    <h3 class="news-entry-title"><?php print $fields['title']->content;?></h3>
  <div class="news-entry-teaser"><?php print $fields['teaser']->content;?></div>
    <p class="news-entry-more-link"><?php print $fields['view_node']->content;?></p>
    <div class="news-entry-footer">
        <p class="news-entry-comment-count"><?php print $fields['comment_count']->content;?></p>
        <p class="news-entry-posted-by">
          Posted by <?php print $fields['name']->content;?> 
          on <?php print $date->format('F j, Y');?>
          at <?php print $date->format('g:ia');?>
        </p>
    </div>
</div>

