package com.example.myapplication;

public class ChatRoomDisplay {
    private String name,url_icone;

    private int owner_id;
    private int id;

    private int nb_personnes;

    public ChatRoomDisplay(){

    }

    public ChatRoomDisplay(String name,int owner_id,String url_icone,int id){
        this.name=name;
        this.owner_id= owner_id;
        this.url_icone=url_icone;
        this.id=id;
    }


    public String getUrl_icone() {
        return url_icone;
    }

    public void setUrl_icone(String url_icone) {
        this.url_icone = url_icone;
    }

    public int getOwner_id() {
        return owner_id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getNb_personnes() {
        return nb_personnes;
    }

    public void setNb_personnes(int nb_personnes) {
        this.nb_personnes = nb_personnes;
    }
}
