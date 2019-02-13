<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=IMayFly;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

//$now = new DateTime();
$listPosts = $bdd->query('SELECT * FROM post');

foreach ($listPosts as $post){
    if($post['title'] == 'test'){
        $req = $bdd->prepare('DELETE FROM post WHERE id = '.$post['id']);
        $req->execute();
    }
}