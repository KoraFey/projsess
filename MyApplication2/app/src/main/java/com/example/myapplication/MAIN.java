package com.example.myapplication;

import static com.example.myapplication.MainActivity.API_URL;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;

import android.content.Intent;
import android.os.Bundle;
import android.view.inputmethod.TextAttribute;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;
import okhttp3.ResponseBody;

public class MAIN extends AppCompatActivity {
    private TextView title;
    private String id;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.mainlayout);
        title = findViewById(R.id.titleMain);
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
                        JSONObject object;

                        try {
                            jsonId= responseBody.string();
                        } catch (IOException e) {
                            throw new RuntimeException(e);
                        }

                        try {
                            object = new JSONObject(jsonId);
                        } catch (JSONException e) {
                            throw new RuntimeException(e);
                        }

                        try {
                            if(object.getString("dark_mode").equals("1")){
                                AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_YES);
                            }
                        } catch (JSONException e) {
                            throw new RuntimeException(e);
                        }
                    }
                });



















            }
        }).start();



    }
}