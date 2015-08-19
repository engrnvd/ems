<?php
require_once 'initialize.php';

//$personwo = new Person();
//$person = new Person(3);
//$personwrong = new Person(5);

//pr($personwo,'personwo');
//pr($person,'$person');
//pr($personwrong,'$personwrong');

//// ***************************************
//if( $personwrong ){
//    echo '$personwrong is not null';
//}else{
//    echo '$personwrong is null';
//}
//echo "<br>";
//// ***************************************
//if( !empty($personwrong) ){
//    echo '$personwrong is not empty()';
//}else{
//    echo '$personwrong is empty()';
//}
//echo "<br>";
//// ***************************************
//echo '$personwrong->isEmpty() is: ';
//echo $personwrong->isEmpty() ? "true" : "false";
//echo "<br>";

//echo '$person->isEmpty() is: ';
//echo $person->isEmpty() ? "true" : "false";
//echo "<br>";

// findByCondition
//$persons = Person::findByCondition("first_name='Muhammad'");
//$person = Person::findOneByCondition("phone='03213007212'");
//pr($persons);
//pr($person);

// dbSave, Delete*********************
$person = new Person();
$person->first_name->val = "Allah";
$person->last_name->val = 'Wasayaaa1';
$person->phone->val = '804209211';
$person->dob->val = '1998-03-01';
$person->pr("before saving");
$person->dbSave();
$person = new Person(3);
$person->pr("after saving");
//$student = new Student(1);
//$student->pr("before saving");
//$student->city->val = 'Ryk';
//$student->dbSave();
//$student->pr("after saving");


//$personToDelete = new Person(6);
//$personToDelete->dbRemove();
//Person::dbDelete(7);

//dynamic props*****************************
//$person = new Person(1);
//$person->favBook = 'Quran';
//$person->pr();

//$guardian = new Guardian(1);
//pr($guardian,'this is the guardian(1)');
//pr(get_class($guardian));
//pr(get_parent_class($guardian));

// child recs
//$class = new Clas(3);
//pr($class);
//$class->pr();
//$class->prChildRecs();
//pr($class->subjectCombinations());
//pr($class->config());
//pr($class->class_sections());
//pr($class->students());
//pr($class->maxRollNum());


// validate()******************************
//$student = new Student(1);
////$student->status->val = 'pta nhi';
//$student->roll_num->val = "4A";
//$student->guardian_id->val = '23';
//$student->class_id->val = '1';
//$student->section->val = '2';
//$student->validate();
//$student->pr();
//pr($student->title());
//pr($student->getErrors(), "Errors");
//pr($student);

// delete, cascade / restrict*************************
//$class = new Clas(3);
//$class->pr();
//pr($class->dbRemove());
//$class->prChildRecs();
//pr(Clas::$childClasses);

// month **********************
//$advRec = new Advance_record();
//$advRec->month->val = 2;
//$advRec->pr();

//test *************************
//$test = new Test(1);
//pr($test->autoInsertTest_record());