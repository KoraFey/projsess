package com.example.myapplication;

import static com.example.myapplication.MainActivity.API_URL;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import com.fasterxml.jackson.databind.ObjectMapper;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import okhttp3.ResponseBody;

public class ChatRoom extends AppCompatActivity {
    private TextView titre,input;
    private Button retour;
    private ImageView send;

    private ListView scrollView;

    private OkHttpClient client;
    MediaType JSON ;

    private String token,id,chatId;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_chat_room);
        titre = findViewById(R.id.tChat);

        retour = findViewById(R.id.buttonretour);
        send = findViewById(R.id.sendMessage);
        scrollView = findViewById(R.id.messages);

        id = getIntent().getStringExtra("user_id");
        token = getIntent().getStringExtra("token");
        titre.setText(getIntent().getStringExtra("name"));
        chatId=getIntent().getStringExtra("chat_id");
        JSON = MediaType.parse("application/json; charset=utf-8");

        input = findViewById(R.id.inputMess);





        loadMessage();









        send.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                sendMessage();
            }
        });
        retour.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
    }


    private void loadMessage(){
        client = new OkHttpClient();



        Request requete = new Request.Builder()
                .url(API_URL + "/api/messages/"+chatId)
                .header("Authorization", "Bearer "+token)
                .build();
        new Thread(new Runnable() {
            @Override
            public void run() {
                Response res = null;

                try {
                    res= client.newCall(requete).execute();
                } catch (IOException e) {
                    throw new RuntimeException(e);
                }

                Response finalRes = res;
                ChatRoom.this.runOnUiThread(new Runnable() {
                    Message1[]  list;
                    ObjectMapper mapper = new ObjectMapper();
                    @Override
                    public void run() {
                        ResponseBody body = finalRes.body();
                        try {
                            String json = body.string();
                            list = mapper.readValue(json,Message1[].class);
                            messageAdapter adapter = new messageAdapter(ChatRoom.this,R.layout.message ,list );
                            scrollView.setAdapter(adapter);
                        } catch (IOException e) {
                            throw new RuntimeException(e);
                        }
                    }
                });
            }
        }).start();
    }


    private void sendMessage(){
        client = new OkHttpClient();
        JSONObject obj = new JSONObject();
    try{
        obj.put("user_id",id);
        obj.put("message", input.getText().toString());
        obj.put("chatroom_id", chatId);
    } catch (JSONException e) {
        throw new RuntimeException(e);
    }
        RequestBody body = RequestBody.create(String.valueOf(obj),JSON);

        Request requete = new Request.Builder()
                .url(API_URL + "/api/messages/"+chatId)
                .header("Authorization", "Bearer "+token)
                .post(body)
                .build();
    }


    Handler handler = new Handler();
    Runnable runnable = new Runnable() {
        @Override
        public void run() {
            loadMessage();
            handler.postDelayed(this, 1000 * 1);
        }
    };
}