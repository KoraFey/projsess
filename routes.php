<?php

require_once __DIR__.'/router.php';

get('/', 'index.php');
get('/index.php', 'index.php');
get('/profil.php', 'profil.php');
get('/chatroom.php','chatroom.php');
any('/login.php', 'login.php');
any('/newUser.php', 'newUser.php');

get('/api/getSettings/$id', '/api/getSettings.php');


get('/api/posts', '/api/post/getPosts.php');




post('/api/users', '/api/newUserMobile.php');
post('/api/logins', '/api/loginMobile.php');




put('/api/posts/$id', '/api/post/putPost.php');
delete('/api/posts/$id', '/api/post/deletePost.php');
put('/api/setSettings/$id', '/api/setSettings.php');


//route introuvable
any('/404','404.php');
