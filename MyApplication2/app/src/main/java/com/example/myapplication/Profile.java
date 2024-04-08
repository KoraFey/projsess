package com.example.myapplication;

import static com.example.myapplication.MainActivity.API_URL;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
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

public class Profile extends AppCompatActivity {

    private Button cancel,submit;

    private EditText username,mpd1,mpd2;

    private OkHttpClient client;

    private String id;

    private String token;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.profile);

        cancel = findViewById(R.id.buttonretour1);
        submit = findViewById(R.id.updateProfile);
        username = findViewById(R.id.username);
        mpd1 = findViewById(R.id.mdp1);
        mpd2 = findViewById(R.id.mdp2);
        id = getIntent().getStringExtra("id");
        token = getIntent().getStringExtra("token");

        username.setText(getIntent().getStringExtra("username"));
        cancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                setResult(RESULT_OK);
                finish();
            }
        });
        submit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                client = new OkHttpClient();
                MediaType JSON = MediaType.parse("application/json; charset=utf-8");
                JSONObject obj = new JSONObject();
                if((mpd1.getText().toString().equals(mpd2.getText().toString()))&&(mpd1.getText().length()!=0)) {
                    try {
                        obj.put("username", username.getText());
                        obj.put("password", mpd1.getText());
                    } catch (JSONException e) {
                        throw new RuntimeException(e);
                    }
                    RequestBody body = RequestBody.create(String.valueOf(obj), JSON);

                    Request requete = new Request.Builder()
                            .url(API_URL + "/api/modifyUser/" + id)
                            .header("Authorization", "Bearer " + token)
                            .post(body)
                            .build();
                    new Thread(new Runnable() {
                        Response rep;
                        @Override
                        public void run() {
                            try {
                               rep = client.newCall(requete).execute();
                            } catch (IOException e) {
                                throw new RuntimeException(e);
                            }

                            Profile.this.runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    if(rep.code()==200){
                                        setResult(2);
                                        finish();
                                    }
                                    else{
                                        Toast toast = Toast.makeText(Profile.this,"error during update",Toast.LENGTH_SHORT);
                                        toast.show();
                                    }

                                }
                            });




                        }
                    }).start();
                }
                else{
                    Toast toast = Toast.makeText(Profile.this,"mot de passe invalid",Toast.LENGTH_SHORT);
                    toast.show();
                }

            }
        });

    }
}