<?php

function userAvatar(){
    $fileNameArr = explode( '/', backpack_auth()->user()->avatar);
    $fileName = $fileNameArr[count($fileNameArr) - 1];
    return route('user.avatar' , [$fileName]);
}
