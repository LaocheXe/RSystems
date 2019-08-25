<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2009 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

//$RANK_TEMPLATE['start']	= "
//<div class='faq-start'>{FAQ_SUBMIT_QUESTION: expand=1}
//{FAQ_SUBMIT_QUESTION_LIST}
//";

$RANK_TEMPLATE['start']	= "<div class='rank-start'>";

$RANK_TEMPLATE['end']	= "
	<div class='rank-end'></div>
</div>
";

$RANK_TEMPLATE['all']['start'] = "
<div>
	<h2 class='raank-listall'>{RANK_CATEGORY=extend}</h2>
	<ul class='rank-listall'>
";
$RANK_TEMPLATE['all']['item'] = "
		<li class='rank-listall'>{RANK_RANKS=expand|share=1}</li>
";
$RANK_TEMPLATE['all']['end'] = "
	</ul>
</div>
";

$RANK_TEMPLATE['caption'] = "{RANK_CAPTION} <small>{RANK_COUNT}</small>";

// Start of LaocheXe Templates
$ROSTER_TEMPLATE['jua'] = "

";


