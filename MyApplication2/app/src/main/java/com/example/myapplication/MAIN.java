package com.example.myapplication;

import static com.example.myapplication.MainActivity.API_URL;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;

import android.content.Intent;
import android.os.Bundle;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.PopupWindow;
import android.widget.Switch;
import android.widget.TextView;
import android.widget.Toast;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import okhttp3.ResponseBody;

public class MAIN extends AppCompatActivity {
    private Comments[] comments;

    private boolean chatroomDisplay ;
    private boolean marketDisplay;
    private boolean postDisplay;
    private TextView title;
    private EditText searchUser;
    private Button  chat,market,profile,newChat, search,feed,post;
    private ImageButton set;

    private ListView scrollView;

    private LinearLayout layout;

    private LinearLayout lay;
    private JSONObject settings;
    private String token,id,username;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.mainlayout);
        title = findViewById(R.id.titleMain);
        searchUser=findViewById(R.id.searchMain);
        chat=findViewById(R.id.chat);
        profile=findViewById(R.id.profile);
        market=findViewById(R.id.market);
        set=findViewById(R.id.settings);
        newChat = findViewById(R.id.createchat);
        scrollView = findViewById(R.id.list);
        layout=findViewById(R.id.linear);
        chatroomDisplay=false;
        postDisplay=false;
        marketDisplay=false;
        search = findViewById(R.id.searchButton);
        feed = findViewById(R.id.Myfeed);
        post = findViewById(R.id.createPost);
        comments = new Comments[0];








        token = getIntent().getStringExtra("token");
        id = getIntent().getStringExtra("userId");
        username = getIntent().getStringExtra("username");
        OkHttpClient okHttpClient = new OkHttpClient();
        Request request = new Request.Builder()
                .url(API_URL + "/api/getSettings/"+id)
                .header("Authorization", "Bearer "+token)
                .get()
                .build();
        new Thread (new Runnable() {
            Response response;
            @Override
            public void run() {
                try {
                    response = okHttpClient.newCall(request).execute();
                } catch (IOException e) {
                    throw new RuntimeException(e);
                }

                ResponseBody responseBody = response.body();

                MAIN.this.runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        String jsonId="";


                        try {
                            jsonId= responseBody.string();
                        } catch (IOException e) {
                            throw new RuntimeException(e);
                        }

                        try {
                            settings = new JSONObject(jsonId);
                        } catch (JSONException e) {
                            throw new RuntimeException(e);
                        }

                        try {
                            if (settings.getString("dark_mode").equals("1")) {
                                AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_YES);
                            }
                        } catch (JSONException e) {
                            throw new RuntimeException(e);
                        }



                    }
                });

            }
        }).start();

    market.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            loadPosts(false,"annonce");
        }
    });
    post.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            CreatePopUpPost();
        }
    });

    feed.setOnClickListener(new View.OnClickListener() {

        @Override
        public void onClick(View v) {
            postDisplay = true;
            marketDisplay=false;
            chatroomDisplay=false;
            loadPosts(false,"actualite");
        }
    });

    search.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            if(!(searchUser.getText().equals(""))){
                if(chatroomDisplay)
                    loadChatRooms(true);
                else if(marketDisplay){
                    loadPosts(true,"annonce");
                }
                else if(postDisplay){
                    loadPosts(true,"actualite");
                }
            }

        }
    });


    chat.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            searchUser.setText("");
            chatroomDisplay=true;
            postDisplay = false;
            marketDisplay=false;
            loadChatRooms(false);
        }
    });
    newChat.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            CreatePopUpChat();
        }
    });
    set.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            CreatePopUpSettings();
        }
    });

    profile.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            Intent intent = new Intent(MAIN.this,Profile.class);
            intent.putExtra("token",token);
            intent.putExtra("id",id);
            intent.putExtra("username",username);



            startActivity(intent);
        }
    });
    }


    private void loadPosts(boolean user, String type){
        OkHttpClient client;
        client = new OkHttpClient();
        MediaType JSON = MediaType.parse("application/json; charset=utf-8");
        Request requete;
        if(user) {
            String name = searchUser.getText().toString();
            requete = new Request.Builder()
                    .url(API_URL + "/api/getPostOf/"  + name + "/" + type)
                    .header("Authorization", "Bearer " + token)
                    .build();
        }
        else{
            requete = new Request.Builder()
                    .url(API_URL + "/api/posts"+ "/" + type)
                    .header("Authorization", "Bearer " + token)
                    .build();
        }


        new Thread(new Runnable() {
            @Override
            public void run() {
                String jsonId;
                int code;
                Response response = null;
                ResponseBody responseBody;
                try {
                    response = client.newCall(requete).execute();
                    code = response.code();
                    responseBody = response.body();
                    jsonId = responseBody.string();
                } catch (IOException e) {
                    throw new RuntimeException(e);
                }





                    MAIN.this.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            Post[] list;

                            Post post = new Post();
                            ObjectMapper mapper = new ObjectMapper();

                            if(code == 404){
                                Toast.makeText(MAIN.this,"mauvais username",Toast.LENGTH_LONG).show();
                            }
                            else {
                                try {



                                    list = mapper.readValue(jsonId, Post[].class);


                                    PostAdapter adaptater = new PostAdapter(MAIN.this, R.layout.post_layout, list, MAIN.this);
                                    scrollView.setAdapter(adaptater);


                                } catch (IOException e) {
                                    throw new RuntimeException(e);
                                }
                            }


                        }
                    });



            }
        }).start();
    }



    private void loadChatRooms(boolean user){
        OkHttpClient client;
        client = new OkHttpClient();
        MediaType JSON = MediaType.parse("application/json; charset=utf-8");
        Request requete;
        if(user) {
            String name = searchUser.getText().toString();
            requete = new Request.Builder()
                    .url(API_URL + "/api/getChatRoomUserWith/" + id+ "/" + name)
                    .header("Authorization", "Bearer " + token)
                    .build();
        }
        else{
            requete = new Request.Builder()
                    .url(API_URL + "/api/chatrooms/" + id)
                    .header("Authorization", "Bearer " + token)
                    .build();
        }
        new Thread(new Runnable() {
            @Override
            public void run() {
                Response response = null;
                try {
                    response = client.newCall(requete).execute();
                } catch (IOException e) {
                    throw new RuntimeException(e);
                }
                ResponseBody responseBody = response.body();
                MAIN.this.runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        ChatRoomDisplay[]  list;
                        ChatRoomDisplay test = new ChatRoomDisplay();
                        ObjectMapper mapper = new ObjectMapper();
                        String jsonId;
                        try {
                            jsonId=responseBody.string();
                           list= mapper.readValue(jsonId, ChatRoomDisplay[].class);


                            ChatDisplayAdapter adaptater = new ChatDisplayAdapter(MAIN.this, R.layout.chat_display, list);
                            scrollView.setAdapter(adaptater);
                            scrollView.setClickable(true);
                            scrollView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                                @Override
                                public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                                    Intent intent = new Intent(MAIN.this,ChatRoom.class);
                                    intent.putExtra("chat_id",String.valueOf( list[position].getId()));
                                    intent.putExtra("token",MAIN.this.token);
                                    intent.putExtra("user_id" , MAIN.this.id);
                                    intent.putExtra("name",list[position].getName());
                                    intent.putExtra("username",username);
                                    startActivity(intent);
                                }
                            });
                        } catch (IOException e) {
                            throw new RuntimeException(e);
                        }




                    }
                });

            }
        }).start();
    }






    private void CreatePopUpChat(){
        LayoutInflater inflater = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
        View popUp = inflater.inflate((R.layout.pop_chat),null);
        int width = ViewGroup.LayoutParams.MATCH_PARENT;
        int height = ViewGroup.LayoutParams.WRAP_CONTENT;
        boolean focusable = true;
        PopupWindow popupWindow = new PopupWindow(popUp,width,height,focusable);
        layout.post(new Runnable() {
            @Override
            public void run() {
                popupWindow.showAtLocation(layout, Gravity.CENTER,0,0);
            }
        });

        Button add = popUp.findViewById(R.id.addUrl);
        Button create = popUp.findViewById(R.id.createNewPost);
        EditText titre = popUp.findViewById(R.id.newDescription);

        create.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                lay=popUp.findViewById(R.id.layout_listPost);
                int t = lay.getChildCount();
                JSONArray array = new JSONArray();
                boolean empty=false;
                for(int i =0;i < lay.getChildCount();i++){
                     View member =  lay.getChildAt(i);
                     EditText memberName = member.findViewById(R.id.newMemberName);
                     if(memberName.getText().toString().equals("")) {
                         i=lay.getChildCount();
                         empty=true;
                     }
                     else{
                         array.put(memberName.getText().toString());
                     }
                }
                if(titre.getText().length()==0){
                    empty=true;
                }
                if(empty){
                    Toast toast = Toast.makeText(MAIN.this,"les username ou le titre sont mal remplis",Toast.LENGTH_SHORT);
                    toast.show();
                }
                else{
//                    ObjectMapper mapper= new ObjectMapper();
//                    String json = null;
//                    try {
//                        json = mapper.writeValueAsString(list);
//                    } catch (JsonProcessingException e) {
//                        throw new RuntimeException(e);
//                    }

                    JSONObject obj = new JSONObject();

                    try {
                        obj.put("titre", titre.getText().toString());
                        obj.put("users",array);
                        obj.put("owner",id);
                    } catch (JSONException e) {
                        throw new RuntimeException(e);
                    }
                    OkHttpClient client;
                    client = new OkHttpClient();
                    MediaType JSON = MediaType.parse("application/json; charset=utf-8");
                    RequestBody corpsRequete = RequestBody.create(String.valueOf(obj), JSON);

                    Request requete = new Request.Builder()
                            .url(API_URL + "/api/createChat")
                            .header("Authorization", "Bearer "+token)
                            .post(corpsRequete)
                            .build();

                    new Thread (new Runnable() {
                        Response response;
                        @Override
                        public void run() {
                            try {
                                response = client.newCall(requete).execute();
                            } catch (IOException e) {
                                throw new RuntimeException(e);
                            }

                            ResponseBody responseBody = response.body();
                            String s;
                            try {
                                s = responseBody.string();
                            } catch (IOException e) {
                                throw new RuntimeException(e);
                            }
                            MAIN.this.runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    if(!(s.equals("\"good\""))){
                                        Toast toast = Toast.makeText(MAIN.this,"les username sont invalide", Toast.LENGTH_SHORT);
                                        toast.show();
                                    }
                                    else{
                                        popupWindow.dismiss();
                                    }




                                }
                            });

                        }
                    }).start();




                }





            }
        });
        add.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                lay=popUp.findViewById(R.id.layout_listPost);

                addMember();
            }
        });







    }


    private void CreatePopUpSettings(){
        LayoutInflater inflater = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
        View popUp = inflater.inflate((R.layout.pop_settings),null);
        int width = ViewGroup.LayoutParams.MATCH_PARENT;
                int height = ViewGroup.LayoutParams.WRAP_CONTENT;
                boolean focusable = true;
        PopupWindow popupWindow = new PopupWindow(popUp,width,height,focusable);
        layout.post(new Runnable() {
            @Override
            public void run() {
                popupWindow.showAtLocation(layout, Gravity.TOP,0,0);
            }
        });
        Switch dark = popUp.findViewById(R.id.dark_mode);
        Switch notif = popUp.findViewById(R.id.notification);
        try {
            if(settings.getString("dark_mode").equals("1")){
                dark.setChecked(true);
            }
            else if(settings.getString("notification").equals("1")){
                notif.setChecked(true);
            }
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        notif.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                try {
                    if (dark.isChecked()) {
                        settings.put("notification", "1");
                    }
                    else{
                        settings.put("notification", "0");
                    }
                } catch(JSONException e){
                    throw new RuntimeException(e);
                }

                updateSettings(settings);
            }
        });
        dark.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                try {
                    if (dark.isChecked()) {
                        settings.put("dark_mode", "1");
                    }
                    else{
                        settings.put("dark_mode", "0");
                    }
                    } catch(JSONException e){
                        throw new RuntimeException(e);
                    }

                updateSettings(settings);
            }
        });

    }
    private void updateSettings(JSONObject obj){
        OkHttpClient client;
        client = new OkHttpClient();
        MediaType JSON = MediaType.parse("application/json; charset=utf-8");

        RequestBody corpsRequete = RequestBody.create(String.valueOf(obj), JSON);


        Request requete = new Request.Builder()
                .url(API_URL + "/api/setSettings/"+id)
                .header("Authorization", "Bearer "+token)
                .put(corpsRequete)
                .build();
        new Thread(new Runnable() {
            @Override
            public void run() {
                Response response = null;
                try {
                    response = client.newCall(requete).execute();
                } catch (IOException e) {
                    throw new RuntimeException(e);
                }
            }
        }).start();
        refreshSettings();

    }

    private void refreshSettings(){
        try {
            if(settings.getString("dark_mode").equals("1")){
                AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_YES);
            }
            else{
                AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO);
            }
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
    }

    private void addMember(){
        final View memberView = getLayoutInflater().inflate(R.layout.new_member_row,null,false);
        EditText editText = (EditText) memberView.findViewById(R.id.newMemberName);
        ImageButton supp =(ImageButton) memberView.findViewById(R.id.supp);

        supp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                lay.removeView(memberView);
            }

        });
        lay.addView(memberView);
    }


    private void CreatePopUpPost(){
        LayoutInflater inflater = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
        View popUp = inflater.inflate((R.layout.pop_post),null);
        int width = ViewGroup.LayoutParams.MATCH_PARENT;
        int height = ViewGroup.LayoutParams.WRAP_CONTENT;
        boolean focusable = true;
        PopupWindow popupWindow = new PopupWindow(popUp,width,height,focusable);
        layout.post(new Runnable() {
            @Override
            public void run() {
                popupWindow.showAtLocation(layout, Gravity.CENTER,0,0);
            }
        });

        Button add = popUp.findViewById(R.id.addUrl);
        Button create = popUp.findViewById(R.id.createNewPost);
        EditText titre = popUp.findViewById(R.id.newDescription);

        create.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                lay=popUp.findViewById(R.id.layout_listPost);
                int t = lay.getChildCount();
                JSONArray array = new JSONArray();
                boolean empty=false;
                for(int i =0;i < lay.getChildCount();i++){
                    View member =  lay.getChildAt(i);
                    EditText memberName = member.findViewById(R.id.newMemberName);
                    if(memberName.getText().toString().equals("")) {
                        i=lay.getChildCount();
                        empty=true;
                    }
                    else{
                        array.put(memberName.getText().toString());
                    }
                }
                if(titre.getText().length()==0){
                    empty=true;
                }
                if(empty){
                    Toast toast = Toast.makeText(MAIN.this,"les url ou la descrption sont mal remplis",Toast.LENGTH_SHORT);
                    toast.show();
                }
                else{
                    JSONObject obj = new JSONObject();

                    try {
                        obj.put("id_type", "actualite");
                        obj.put("description",titre.getText().toString());
                        obj.put("url_image",array);
                    } catch (JSONException e) {
                        throw new RuntimeException(e);
                    }
                    OkHttpClient client;
                    client = new OkHttpClient();
                    MediaType JSON = MediaType.parse("application/json; charset=utf-8");
                    RequestBody corpsRequete = RequestBody.create(String.valueOf(obj), JSON);

                    Request requete = new Request.Builder()
                            .url(API_URL + "/api/post")
                            .header("Authorization", "Bearer "+token)
                            .post(corpsRequete)
                            .build();

                    new Thread (new Runnable() {
                        Response response;
                        @Override
                        public void run() {
                            try {
                                response = client.newCall(requete).execute();
                            } catch (IOException e) {
                                throw new RuntimeException(e);
                            }

                            ResponseBody responseBody = response.body();
                            int s;
                            s =response.code();
                            MAIN.this.runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    if(s == 200){
                                        popupWindow.dismiss();
                                    }






                                }
                            });

                        }
                    }).start();




                }





            }
        });
        add.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                lay=popUp.findViewById(R.id.layout_listPost);

                addMember();
            }
        });







    }


//    @Override
//    public void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
//        super.onActivityResult(requestCode, resultCode, data);
//        switch(resultCode){
//            case RESULT_OK:
//                Toast toast = Toast.makeText(MAIN.this,"you cancelled",Toast.LENGTH_SHORT);
//                toast.show();
//                break;
//            case 2:
//                toast = Toast.makeText(MAIN.this,"profile updated",Toast.LENGTH_SHORT);
//                toast.show();
//
//        }
//    }


public String getToken(){
        return token;
}

    public Comments[] loadComment(int id){
        //comments = new Comments[0];

        OkHttpClient okHttpClient = new OkHttpClient();
        Request request = new Request.Builder()
                .url(API_URL + "/api/getComments/"+id)
                .header("Authorization", "Bearer " + token)
                .get()
                .build();
       Thread t = new Thread (new Runnable()  {
            Response response;
            @Override
            public void run() {
                try {
                    response = okHttpClient.newCall(request).execute();
                } catch (IOException e) {
                    throw new RuntimeException(e);
                }
                if(response.code()!=402) {
                    ResponseBody responseBody = response.body();
                    MAIN.this.runOnUiThread(new Runnable()  {
                        @Override
                        public void run() {
                            String json;
                            try {
                                json = responseBody.string();
                            } catch (IOException e) {
                                throw new RuntimeException(e);
                            }
                            ObjectMapper mapper = new ObjectMapper();
                            try {
                                comments = mapper.readValue(json, Comments[].class);

                            } catch (JsonProcessingException e) {
                                throw new RuntimeException(e);
                            }
                        }
                    });

                }


            }
        });
       t.start();
       try {
           t.join();
           return comments;
       } catch (InterruptedException e) {
           throw new RuntimeException(e);
       }


    }

    public String getId(){
        return id;
    }



}