<?php
//print "Hello\n";
//print_r($type);
//print "Type".$type;

$qarray['multiple choice multiple answer']['moderate']=$ques['mmModerate'];
$qarray['multiple choice multiple answer']['easy']=$ques['mmEasy'];
$qarray['multiple choice multiple answer']['tough']=$ques['mmTough'];

$qarray['multiple choice single answer']['moderate']=$ques['msModerate'];
$qarray['multiple choice single answer']['easy']=$ques['msEasy'];
$qarray['multiple choice single answer']['tough']=$ques['msTough'];

$qarray['short text']['moderate']=$ques['desModerate'];
$qarray['short text']['easy']=$ques['desEasy'];
$qarray['short text']['tough']=$ques['fileTough'];

$qarray['file upload']['moderate']=$ques['fileModerate'];
$qarray['file upload']['easy']=$ques['fileEasy'];
$qarray['file upload']['tough']=$ques['fileTough'];

$qarray['yes / no']['moderate']=$ques['tfModerate'];
$qarray['yes / no']['easy']=$ques['tfEasy'];
$qarray['yes / no']['tough']=$ques['tfTough'];

foreach($qarray as $type=>$mode){
	
	pa($mode);
}
?>
