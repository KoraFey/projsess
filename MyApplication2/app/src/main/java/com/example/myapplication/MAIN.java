package com.example.myapplication;

import static com.example.myapplication.MainActivity.API_URL;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;

import android.content.Intent;
import android.os.Bundle;
import android.text.Layout;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.TextAttribute;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.PopupWindow;
import android.widget.ScrollView;
import android.widget.Switch;
import android.widget.TextView;
import android.widget.Toast;

import com.fasterxml.jackson.databind.ObjectMapper;
import com.google.gson.Gson;
import com.google.gson.JsonArray;
import com.google.gson.reflect.TypeToken;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.lang.reflect.Member;
import java.util.ArrayList;

import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import okhttp3.ResponseBody;

public class MAIN extends AppCompatActivity {
    private TextView title;
    private EditText searchUser;
    private Button  chat,market,profile,set,newChat;
    private String id;

    private ListView scrollView;

    private LinearLayout layout;

    private LinearLayout lay;
    private JSONObject settings;
    private String token;
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








        token = getIntent().getStringExtra("token");
        id = getIntent().getStringExtra("userId");
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


    chat.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            LoadChatRooms();
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
    }


    private void LoadChatRooms(){
        OkHttpClient client;
        client = new OkHttpClient();
        MediaType JSON = MediaType.parse("application/json; charset=utf-8");


        Request requete = new Request.Builder()
                .url(API_URL + "/api/chatrooms/"+id)
                .header("Authorization", "Bearer "+token)
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


                            ChatDisplayAdapter adaptateur = new ChatDisplayAdapter(MAIN.this, R.layout.chat_display, list);
                            scrollView.setAdapter(adaptateur);
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
                popupWindow.showAtLocation(layout, Gravity.BOTTOM,0,0);
            }
        });

        Button add = popUp.findViewById(R.id.addMember);
        Button create = popUp.findViewById(R.id.createCh);

        create.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                lay=popUp.findViewById(R.id.layout_list);
                int t = lay.getChildCount();
                ArrayList<String> list = new ArrayList<String>();
                boolean empty=false;
                for(int i =0;i < lay.getChildCount();i++){
                     View member =  lay.getChildAt(i);
                     EditText memberName = member.findViewById(R.id.newMemberName);
                     if(memberName.getText().toString().equals("")) {
                         i=lay.getChildCount();
                         empty=true;
                     }
                     else{
                         list.add(memberName.getText().toString());
                     }


                    //list[i] = member.getText().toString();
                }
                if(empty){
                    Toast toast = Toast.makeText(MAIN.this,"les username sont mal remplis",Toast.LENGTH_SHORT);
                    toast.show();
                }
                else{
                    String json = new Gson().toJson(list);

                    JSONObject obj = new JSONObject();
                    try {
                        obj.put( "users",json);
                    } catch (JSONException e) {
                        throw new RuntimeException(e);
                    }

                    popupWindow.dismiss();


                }





            }
        });
        add.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                lay=popUp.findViewById(R.id.layout_list);

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
                popupWindow.showAtLocation(layout, Gravity.BOTTOM,0,0);
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





}