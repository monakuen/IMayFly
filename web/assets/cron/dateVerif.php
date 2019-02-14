<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=IMayFly;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

$now = new DateTime();
$listPosts = $bdd->query('SELECT * FROM post');


foreach ($listPosts as $post){
    $datePost = new DateTime($post['date']);
    $diff = $datePost->diff($now);
    $nb_jours = $diff->days;
    if($nb_jours > 10){
        $req = $bdd->prepare('DELETE FROM post WHERE id = '.$post['id']);
        $req->execute();
    }
}

//    if($nb_jours > 5)
//    if($post['title'] == 'test')