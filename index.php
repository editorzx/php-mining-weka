<?php
header("Access-Control-Allow-Origin: *");
$api = $_REQUEST['api'];
$gender = $_REQUEST['gender'];
$region = $_REQUEST['region'];
$admit = $_REQUEST['admit'];
$highschoolgpa = $_REQUEST['highschoolgpa'];
$englishskill = $_REQUEST['englishskill'];
$itthinking = $_REQUEST['itthinking'];
$dohw = $_REQUEST['dohw'];
$askteacher = $_REQUEST['askteacher'];
$fconcern = $_REQUEST['fconcern'];
$testpre = $_REQUEST['testpre'];
$gaming = $_REQUEST['gaming'];
if($api == 'K0xzPs2')
{
include("connect.php");
$data = array ('gender,region,What form of education did you come in?,GPA cumulative high school,Englist,What is your opinion on learning information technology?,Able to do homework and classroom work by yourself,Have the courage to ask a teacher about a question,There is a concern about being addicted to F in various subjects.,Test preparation,Gaming behavior,GPA currently being studied',
                            'male,Central,Portfolio,Excellent,Unsatisfy,Easy,Always try,Sometimes,Never,Read the book 1 week,medium,Appropriate',
                            'female,Eastern,Portfolio,Excellent,Unsatisfy,Normal,Sometimes,Dare,Sometimes,Read book alone,medium,Inappropriate',
							'female,Western,tcas,Excellent,Unsatisfy,Too Hard,Sometimes,Not brave,Every time,Tutoring with friends,medium,Inappropriate',
							'male,Eastern,area quota,Good,Unsatisfy,Normal,Sometimes,Sometimes,Sometimes,Tutoring with friends,medium,Inappropriate',
							'male,Central,Admissions,Unsatisfy,Good,Normal,Sometimes,Sometimes,Sometimes,Tutoring with friends,medium,Appropriate',
							'female,Northeastern,Direct examination,Excellent,Fair,Normal,Sometimes,Sometimes,Every time,Tutoring with friends,medium,Inappropriate',
							'male,Southern,GoodGrade quota,Excellent,Unsatisfy,Normal,Sometimes,Not brave,Sometimes,Not prepared,medium,Appropriate',
							'female,Northern,GoodGrade quota,Excellent,Unsatisfy,Normal,Sometimes,Sometimes,Every time,Tutoring with friends,medium,Inappropriate',
							'male,Central,Get-pat,Good,Fair,Normal,Always try,Sometimes,Never,Read the book 1 night,medium,Appropriate',
							'female,Eastern,area quota,Excellent,Unsatisfy,Normal,Sometimes,Dare,Sometimes,Tutoring with friends,medium,Inappropriate',
							'female,Central,Direct examination,Excellent,Excellent,Normal,Sometimes,Sometimes,Sometimes,Tutoring with friends,medium,Appropriate',
							'male,Central,Direct examination,Good,Excellent,Normal,Always peel friends,Sometimes,Sometimes,Tutoring with friends,medium,Inappropriate',
							'female,Central,O-net,Good,Fair,Normal,Sometimes,Sometimes,Every time,Tutoring with friends,Do not play,Inappropriate',
							'male,Central,Portfolio,Fair,Fair,Normal,Sometimes,Sometimes,Sometimes,Read book alone,high,Appropriate',
							$gender.','.$region.','.$admit.','.$highschoolgpa.','.$englishskill.','.$itthinking.','.$dohw.','.$askteacher.','.$fconcern.','.$testpre.','.$gaming.',?');


$fp = fopen('survey_unseen.csv', 'w');
foreach($data as $line){
 $val = explode(",",$line);
 fputcsv($fp, $val);
}
fclose($fp);
$cmd = 'java -classpath "C:\AppServ\www\mining\weka.jar" weka.core.converters.CSVLoader survey_unseen.csv > survey_unseen.arff ';
exec($cmd,$output);
$cmd1 = 'java -classpath "C:\AppServ\www\mining\weka.jar" weka.classifiers.trees.J48 -T "survey_unseen.arff" -l "SurveyV3-test.model" -p 12'; // 
exec($cmd1,$output1);

$reponse = array();
$show = $output1[sizeof($output1)-2];
$result = substr($show,23,11);

if($result == 'Appropriate')
	$state =  200;
elseif($result == 'Inappropria')
{
   $state =  100;
   $result = 'Inappropriate';
}

$reponse['result'] = $result;
$reponse['state'] = $state;
$reponse['value'] = substr($show,41,13);
echo json_encode( $reponse, JSON_UNESCAPED_UNICODE );   

$queryx = "INSERT INTO data(name, gender, region, didyoucomein, gpabeforenow, english, opinionit, homework, asking, concerntof, testpre, gaming, gpa)
	VALUES ('', '$gender', '$region', '$admit', '$highschoolgpa', '$englishskill', '$itthinking', '$dohw', '$askteacher', '$fconcern', '$testpre', '$gaming', '$result' )";
$resultsql = pg_query($queryx); 
}
?>
