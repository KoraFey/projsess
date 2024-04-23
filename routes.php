<?php
$webAccess = true;
require_once __DIR__.'/router.php';

get('/', 'index.php');
get('/index.php', 'index.php');
get('/profil.php', 'profil.php');
get('/chatroom.php','chatroom.php');
any('/login.php', 'login.php');
any('/newUser.php', 'newUser.php');
any('/page_paiement.php','page_paiement.php');

get('/api/getSettings/$id', '/api/getSettings.php');

get('/api/getPostOf/$name/$type','/api/getPostOf.php');
get('/api/posts/$type', '/api/getPosts.php');




post('/api/users', '/api/newUserMobile.php');
post('/api/logins', '/api/loginMobile.php');
post('/api/auth', './api/auth.php');
post('/api/post', '/api/postArticle.php');
post('/api/postLike', '/api/postLike.php');
post('/api/createChat', '/api/createChat.php');
post('/api/modifyUser/$id','/api/modifyUser.php');
post('/api/postMessagePrivate','/api/postMessagePrivate.php');
post('/api/postMessages','/api/newMessages.php');
post('/api/blockUser','/api/blockUser.php');

post('/api/deletePost', 'api/deletePost.php');

get('/api/getIdOtherPerson/$id/$chatRoomId', '/api/getIdOtherPerson.php');

get('/api/getChatRoomUser/$id', '/api/getChatRoomUser.php');
get('/api/getChatRoomUserWith/$id/$name', '/api/getChatRooomWith.php');

get('/api/chatrooms/$id', '/api/getChatRoomUser.php');
get('/api/chatrooms/$id', '/api/getChatRoomUser.php');
get('/api/messages/$id', '/api/getMessages.php');

put('/api/posts/$id', '/api/post/putPost.php');
delete('/api/posts/$id', '/api/post/deletePost.php');




put('/api/setSettings/$id', '/api/setSettings.php');


//route introuvable
any('/404','404.php');


