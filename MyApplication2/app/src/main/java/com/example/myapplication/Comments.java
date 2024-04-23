package com.example.myapplication;

public class Comments {
    private String commentaire;

    private int user_id;
    private String username;

    public Comments(){

    }

    public String getCommentaire() {
        return commentaire;
    }

    public void setCommentaire(String message) {
        commentaire = message;
    }

    public int getUser_id() {
        return user_id;
    }

    public void setUser_id(int user_id) {
        this.user_id = user_id;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }
}
