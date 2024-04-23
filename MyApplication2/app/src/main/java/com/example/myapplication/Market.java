package com.example.myapplication;

public class Market {
    private String URL_content,username,time,URL_icone,description,titre;
    public Market(String URL_content,String username,String time,String URL_icone,String description, String titre){
        this.titre=titre;
        this.username=username;
        this.description=description;
        this.URL_icone=URL_icone;
        this.URL_content = URL_content;
        this.time = time;

    }

    public String getTime(){
        return time;
    }

    public String getTitre(){
        return titre;
    }

    public String getURL_content(){
        return URL_content;
    }

    public String getURL_icone(){
        return URL_icone;
    }

    public String getUsername(){
        return username;
    }

    public String getDescription(){
        return description;
    }


}
