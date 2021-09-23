<?php

require 'flight/Flight.php';

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=application','root','040319659'));

Flight::route('/', function(){
    $sql = "SELECT * FROM projects";
    $executeSentence = Flight::db()->prepare($sql);
    $executeSentence->execute();

    $dataProjects = $executeSentence->fetchAll();

    Flight::render('header');
    Flight::render('projects/to_list', array('projects' => $dataProjects));
    Flight::render('footer');    
});

Flight::route('GET /create', function(){
    Flight::render('header');
    Flight::render('projects/create');
    Flight::render('footer');    
});

Flight::route('POST /create', function(){    
    $txtName = Flight::request()->data->txtName;

    $txtImage = Flight::request()->files['txtImage']; 

    $date = new DateTime();

    $fileName = ($txtImage['name']!='')?$date->getTimestamp()."_".$txtImage['name']:"";

    $tmpImage = $txtImage['tmp_name'];

    if($tmpImage != "") {
        move_uploaded_file($tmpImage,"img/".$fileName);
    }

    $file = $fileName;
    
    $sql = "INSERT INTO projects(name,image) VALUES (?,?)";
    $executeSentence = Flight::db()->prepare($sql);
    $executeSentence->bindParam(1,$txtName);
    $executeSentence->bindParam(2,$file);
    $executeSentence->execute();
    Flight::redirect('/');
});

Flight::route('GET /edit', function(){
    $txtID = Flight::request()->query['txtID'];
    
    $sql = "SELECT * FROM projects WHERE id=?";
    $executeSentence = Flight::db()->prepare($sql);
    $executeSentence->bindParam(1,$txtID);
    $executeSentence->execute();
    $data=$executeSentence->fetch(PDO::FETCH_ASSOC);

    Flight::render('header');
    Flight::render('projects/edit', array('project' => $data));
    Flight::render('footer');    
});

Flight::route('POST /delete', function(){  
    $txtID = Flight::request()->data->txtID;

    $sql = "SELECT * FROM projects WHERE id=?";
    $executeSentence = Flight::db()->prepare($sql);
    $executeSentence->bindParam(1,$txtID);
    $executeSentence->execute();
    $project=$executeSentence->fetch(PDO::FETCH_ASSOC);

    if(isset($project['image'])) {
        if(file_exists("img/".$project['image'])) {
            unlink("img/".$project['image']);
        }
    }

    $sql = "DELETE FROM projects WHERE id=?"; 
    $executeSentence = Flight::db()->prepare($sql);
    $executeSentence->bindParam(1,$txtID);
    $executeSentence->execute(); 
    Flight::redirect('/');
});

Flight::route('POST /edit', function(){  
    $txtID = Flight::request()->data->txtID;
    $txtName = Flight::request()->data->txtName;
    
    $txtImage = Flight::request()->files['txtImage'];
    
    if(isset($txtImage)) {
        $date = new DateTime();
        $fileName = ($txtImage['name']!='')?$date->getTimestamp()."_".$txtImage['name']:"";
        $tmpImage = $txtImage['tmp_name'];
        if($tmpImage != "") {
            move_uploaded_file($tmpImage,"img/".$fileName);
            
            $sql = "SELECT * FROM projects WHERE id=?";
            $executeSentence = Flight::db()->prepare($sql);
            $executeSentence->bindParam(1,$txtID);
            $executeSentence->execute();
            $project=$executeSentence->fetch(PDO::FETCH_ASSOC);

            if(isset($project['image'])) {
                if(file_exists("img/".$project['image'])) {
                    unlink("img/".$project['image']);
                }
            }

            $sql = "UPDATE projects SET image=? WHERE id=?"; 
            $executeSentence = Flight::db()->prepare($sql);
            $executeSentence->bindParam(1,$fileName);
            $executeSentence->bindParam(2,$txtID);
            $executeSentence->execute(); 
        }
    }

    $sql = "UPDATE projects SET name=? WHERE id=?"; 
    $executeSentence = Flight::db()->prepare($sql);
    $executeSentence->bindParam(1,$txtName);
    $executeSentence->bindParam(2,$txtID);
    $executeSentence->execute(); 
    Flight::redirect('/');
});

Flight::start();

?>