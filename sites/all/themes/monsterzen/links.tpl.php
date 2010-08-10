<?php
/*
Array
(
    [blog_usernames_blog] => Array
        (
            [title] => edcable's blog
            [href] => blog/5
            [attributes] => Array
                (
                    [title] => Read edcable's latest blog entries.
                )

        )

    [comment_add] => Array
        (
            [title] => Add new comment
            [href] => comment/reply/98
            [attributes] => Array
                (
                    [title] => Add a new comment to this page.
                )

            [fragment] => comment-form
        )

    [node_read_more] => Array
        (
            [title] => Read more
            [href] => node/98
            [attributes] => Array
                (
                    [title] => Read the rest of Meet the 2010 Google Summer of Code Mifos Interns.
                )

        )

)

*/
if(!empty($links['blog_usernames_blog'])) 
{
  unset($links['blog_usernames_blog']);
}
?>
<ul class="links">
<?php
// to change the delimiter, just modify the $delimiter value
foreach ($links as $link) {
    
    // get status of clean_url
    if (variable_get('clean_url', 0) && !isset($link['html']))
        // clean URL
        print "<li><a href='/" . $link['href'] . "' title='" . $link['attributes']['title'] . "'>" . $link['title'] . "</a></li>";
    else if (!isset($link['html']))
        // non-clean URL with no html set
        print "<li><a href='/?q=" . $link['href'] . "' title='" . $link['attributes']['title'] . "'>" . $link['title'] . "</a></li>";
    else
        // html must be set! (clean or non-clean URL)
        print "<li>" . str_replace('%2523', '#', $link['title']) . "</li>";
}
?>
</ul>