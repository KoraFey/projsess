package com.example.myapplication;

public class Post {
    private String caption,username,time,URL_content,URL_icone;
    private Boolean isLiked;




    public Post(String username, String time, String URL_content,String caption, String URL_icone,Boolean isLiked){
        this.caption=caption;
        this.isLiked=isLiked;
        this.username=username;
        this.URL_content=URL_content;
        this.time=time;
        this.URL_icone=URL_icone;
    }

    public String getUser(){
        return username;
    }

    public String getTime(){
        return time;
    }
    public String getUrl(){
        return URL_content;
    }
    public String getCaption(){
        return caption;
    }

    public String getIcone(){
        return URL_icone;
    }

    public Boolean getLike(){
        return isLiked;
    }



}
