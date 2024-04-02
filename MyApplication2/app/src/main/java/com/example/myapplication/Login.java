package com.example.myapplication;

import static com.example.myapplication.MainActivity.API_URL;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import com.fasterxml.jackson.core.JsonProcessingException;
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

public class Login extends AppCompatActivity {
    private Button login,reset,createAccount;
    private String token;

    private EditText username,password;
    OkHttpClient client;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.login);
        //affectation des variable au xml
        login = findViewById(R.id.Log_In);
        reset = findViewById(R.id.cancel_login);
        createAccount = findViewById(R.id.create_account);
        username = findViewById(R.id.User_login);
        password = findViewById(R.id.Password_login);



        login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //verifie que les champs username password sont remplis
                if ((username.getText().length() == 0) || (password.getText().length() == 0)) {
                    Toast t = Toast.makeText(getApplicationContext(),"le password ou le username est manquant",Toast.LENGTH_SHORT);
                    t.show();
                } else {
                    int r = checkSelfPermission("android.permission.INTERNET");
                    if (r == PackageManager.PERMISSION_GRANTED) {
                        client = new OkHttpClient();
                        MediaType JSON = MediaType.parse("application/json; charset=utf-8");
                        JSONObject obj = new JSONObject();
                        try {
                            obj.put("username", username.getText().toString());
                            obj.put("password", password.getText().toString());

                        } catch (JSONException e) {
                            throw new RuntimeException(e);
                        }
                        RequestBody corpsRequete = RequestBody.create(String.valueOf(obj), JSON);


                        Request requete = new Request.Builder()
                                .url(API_URL + "/api/auth")
                                .post(corpsRequete)
                                .build();


                        new Thread(new Runnable() {
                            @Override
                            public void run() {
                                //traitement effectué par le thread

                                Response response = null;
                                try {
                                    response = client.newCall(requete).execute();
                                } catch (IOException e) {
                                    throw new RuntimeException(e);
                                }

                                Response finalResponse = response;
                                Login.this.runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        if(finalResponse.code()==200){
                                            ResponseBody responseBody = finalResponse.body();
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
                                            Intent intent = new Intent(Login.this,MAIN.class);
                                            try {
                                                intent.putExtra("userId",object.getString("id"));
                                                intent.putExtra("token",object.getString("token"));
                                            } catch (JSONException e) {
                                                throw new RuntimeException(e);
                                            }
                                            startActivity(intent);
                                        }
                                        else{
                                            Toast.makeText(Login.this, "erreur du login", Toast.LENGTH_LONG).show();
                                        }
                                    }
                                });

                            }
                        }).start();
                    }
                        else{
                        Toast.makeText(Login.this, "Non permis!", Toast.LENGTH_LONG).show();
                    }







                }
            }
        });
        reset.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                username.setText("");
                password.setText("");
            }
        });

        createAccount.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Login.this,newUser.class);
                startActivity(intent);
            }
        });





    }




}
