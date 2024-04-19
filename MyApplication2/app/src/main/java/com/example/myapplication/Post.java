package com.example.myapplication;

public class Post {
    private String description,username,date_publication,URL_content,URL_icone;
    private Boolean isLiked;

    private int id;



    public Post(){

    }






    public Post(String username, String date_publication, String URL_content,String description, String URL_icone,Boolean isLiked,String type,String prix){
        this.description=description;
        this.isLiked=isLiked;
        this.username=username;
        this.URL_content=URL_content;
        this.date_publication=date_publication;
        this.URL_icone=URL_icone;

    }

    public String getUser(){
        return username;
    }

    public String getDate_publication(){
        return date_publication;
    }

    public void setDate_publication(String date_publication){
         this.date_publication = date_publication;
    }
    public String getUrl(){
        return URL_content;
    }
    public String getDescription(){
        return description;
    }

    public void setDescription(String description){
        this.description = description;
    }

    public String getURL_icone(){
        return URL_icone;
    }

    public Boolean getLike(){
        return isLiked;
    }




    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }
}
