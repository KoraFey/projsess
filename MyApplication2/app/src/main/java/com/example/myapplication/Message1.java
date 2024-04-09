package com.example.myapplication;

public class Message1 {
    private String message,username,time;

    boolean sent;
    public Message1(){

    }
    public Message1(String message,String user_id,String time){
        this.message=message;
        this.username=user_id;
        this.time=time;
    }



    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public String getUsername() {
        return username;
    }

    public void setUser_id(String user) {
        this.username = user;
    }

    public String getTime() {
        return time;
    }

    public void setTime(String time) {
        this.time = time;
    }

    public void setSent(boolean sent){
        this.sent=sent;
    }

    public boolean isSent() {
        return sent;
    }
}

