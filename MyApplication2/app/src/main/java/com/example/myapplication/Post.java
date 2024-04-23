package com.example.myapplication;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

public class Post {
    private String description,username,date_publication,url_pfp, type;

    private String[] url;
    private int isLiked, user_id;
    private double prix;

    private int id;



    public Post(){

    }






    public Post(String username, String date_publication, String[] url,String description, String URL_icone,int isLiked,String type,String prix){
        this.description=description;

        this.username=username;

        this.date_publication=date_publication;


    }

    public String getUsername(){
        return username;
    }


    public void setUsername(String username){
        this.username = username;
    }
    public String getDate_publication(){
        return date_publication;
    }

    public void setDate_publication(String date_publication){
         this.date_publication = date_publication;
    }

    public String getDescription(){
        return description;
    }

    public void setDescription(String description){
        this.description = description;
    }



    public int getLike(){
        return isLiked;
    }




    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String[] getUrl() {
        if(url==null){
            url = new String[1];
            url[0]="wert";
        }

        return url;
    }

    public void setUrl(String[] url) {
        this.url = url;
    }

    public String getUrl_pfp() {
        return url_pfp;
    }

    public void setUrl_pfp(String url_pfp) {
        this.url_pfp = url_pfp;
    }

    public double getPrix() {
        return prix;
    }

    public void setPrix(double prix) {
        this.prix = prix;
    }

    public int getUser_id() {
        return user_id;
    }

    public void setUser_id(int user_id) {
        this.user_id = user_id;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public void setIsLiked(int isLiked) {
        this.isLiked = isLiked;
    }
}
