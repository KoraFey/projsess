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
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.Switch;
import android.widget.TextView;
import android.widget.Toast;

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
    private TextView title;
    private EditText searchUser;
    private Button  chat,market,profile,set;
    private String id;

    private LinearLayout layout;
    private JSONObject settings;
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
        layout=findViewById(R.id.linear);




        id = getIntent().getStringExtra("userId");
        OkHttpClient okHttpClient = new OkHttpClient();
        Request request = new Request.Builder()
                .url(API_URL + "/api/getSettings/"+id)
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




    set.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            CreatePopUp();
        }
    });
    }

    private void CreatePopUp(){
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
        Button save;
        save = popUp.findViewById(R.id.close);
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

}