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
import android.widget.Toast;

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

    private String token,id,chatId, username;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_chat_room);
        titre = findViewById(R.id.tChat);

        retour = findViewById(R.id.buttonretour);
        send = findViewById(R.id.sendMessage);
        scrollView = findViewById(R.id.messages);
        scrollView.setTranscriptMode(ListView.TRANSCRIPT_MODE_ALWAYS_SCROLL);
        id = getIntent().getStringExtra("user_id");
        token = getIntent().getStringExtra("token");
        titre.setText(getIntent().getStringExtra("name"));
        username =  getIntent().getStringExtra("username");
        chatId=getIntent().getStringExtra("chat_id");
        JSON = MediaType.parse("application/json; charset=utf-8");

        input = findViewById(R.id.inputMess);





        loadMessage(true);
        final int delay = 1000 * 15;

        Handler handler = new Handler();
        Runnable runnable = new Runnable() {
            @Override
            public void run() {
                loadMessage(false);
                handler.postDelayed(this, 1000 * 1);
            }
        };

        handler.postDelayed(runnable, delay);





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


    private void loadMessage(boolean send){
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
                            for(int i =0;i<list.length;i++){
                                if(list[i].getUsername().equals(username)){
                                    list[i].setSent(true);
                                }
                                else{
                                    list[i].setSent(false);
                                }
                            }
                            messageAdapter adapter = new messageAdapter(ChatRoom.this,R.layout.message ,list );

                            scrollView.setAdapter(adapter);
                        } catch (IOException e) {
                            throw new RuntimeException(e);
                        }
                    }
                });
            }
        }).start();
        if(send){
            scrollView.setStackFromBottom(true);
        }
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
                .url(API_URL + "/api/postMessages")
                .header("Authorization", "Bearer "+token)
                .post(body)
                .build();
        new Thread(new Runnable() {
            Response res;
            @Override
            public void run() {
                try {
                    res =client.newCall(requete).execute();
                } catch (IOException e) {
                    throw new RuntimeException(e);
                }
                ChatRoom.this.runOnUiThread(new Runnable() {
                    @Override
                    public void run() {

                    }
                });
                switch(res.code()){
                    case 200:
                        input.setText("");
                        loadMessage(true);


                        break;
                    case 500:
                        Toast toast=Toast.makeText(ChatRoom.this,"erreur serveur",Toast.LENGTH_SHORT);
                        break;
                }
            }
        }).start();
    }



}