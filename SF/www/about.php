<?php
//
// SourceForge: Breaking Down the Barriers to Open Source Development
// Copyright 1999-2000 (c) The SourceForge Crew
// http://sourceforge.net
//
// $Id$

require "pre.php";    
$HTML->header(array(title=>'About '.$GLOBALS['sys_name']));
?>

<P>
<h2>About <?php print $GLOBALS['sys_name']; ?></h2>

<B>Mission Statement</b><br>
The mission of <?php print $GLOBALS['sys_name']; ?> is to enrich the Xerox Software Development community by providing 
a centralized place for Xerox Developers to share, control and
manage Xerox internally developed software.
<br><br>

<B>People</b><br>
Based on the work done by the world famous SourceForge.net site, the <?php print $GLOBALS['sys_name']; ?> <a href="staff.php">Team</a> has worked hard to make 
<?php print $GLOBALS['sys_name']; ?> a reality, here's your chance to meet the people behind the site.
<br><br>

<b>Thanks</b><br>
We owe a lot of thanks to the people who wrote 
the <a href="/docman/display_doc.php?docid=27&group_id=1">Software</a> that runs <?php print $GLOBALS['sys_name']; ?>.
We'd also like to give <a href="thanks.php">Kudos</a> to the following people and organizations
for helping make <?php print $GLOBALS['sys_name']; ?> happen.
<br><br>

<b>More Information</b><br>
If you have further questions, they might be answered in our
<a href="/docs/site/">Site Documentation</A>, <A href="/docman/display_doc.php?docid=26&group_id=1">Hardware list</A>,
or <A href="/docman/display_doc.php?docid=17&group_id=1">Frequently Asked Questions</A>. 

<?php
$HTML->footer(array());

?>
