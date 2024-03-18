<?php

require_once __DIR__.'/router.php';

get('/', 'index.php');
get('/index.php', 'index.php');
any('/login.php', 'login.php');
any('/newUser.php', 'newUser.php');

get('/api/posts/$id', '/api/post/getPost.php');
get('/api/posts', '/api/post/getPosts.php');
post('/api/posts', '/api/post/postPost.php');
put('/api/posts/$id', '/api/post/putPost.php');
delete('/api/posts/$id', '/api/post/deletePost.php');


//route introuvable
any('/404','404.php');