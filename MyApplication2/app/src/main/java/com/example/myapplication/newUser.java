package com.example.myapplication;

import static com.example.myapplication.MainActivity.API_URL;

import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class newUser extends AppCompatActivity {
    private EditText username,password1,password2;
    private Button submit,reset;
    OkHttpClient client;

    private Boolean profileIserted;
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.create_login);
        profileIserted=false;
        //affectation des variable au xml
        username = findViewById(R.id.User_login);
        password1 = findViewById(R.id.password_check);
        password2 = findViewById(R.id.password_table);
        submit = findViewById(R.id.Submit);
        reset = findViewById(R.id.Cancel);


        submit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //verife que les champs sont remplis
                if(username.getText().toString().equals("")){
                    Toast t = Toast.makeText(getApplicationContext(),"username manquant", Toast.LENGTH_SHORT);
                    t.show();
                }else{
                    if((password1.getText().toString().equals(password2.getText().toString()))&&(password1.getText().length()!=0)){
                        int r = checkSelfPermission("android.permission.INTERNET");
                        if (r == PackageManager.PERMISSION_GRANTED){
                            client = new OkHttpClient();
                            MediaType JSON = MediaType.parse("application/json; charset=utf-8");
                            JSONObject obj = new JSONObject();
                            try {


                                obj.put("username", username.getText().toString());
                                obj.put("password", password1.getText().toString());

                            }
                            catch (JSONException e) {
                                throw new RuntimeException(e);
                            }
                            RequestBody corpsRequete = RequestBody.create(String.valueOf(obj), JSON);


                            Request requete = new Request.Builder()
                                    .url(API_URL+"/api/users")
                                    .post(corpsRequete)
                                    .build();



                            new Thread (new Runnable() {
                                @Override
                                public void run() {
                                    //traitement effectué par le thread

                                    Response response = null;
                                    try {
                                        response = client.newCall(requete).execute();
                                        System.out.println(requete);
                                    } catch (IOException e) {
                                        throw new RuntimeException(e);
                                    }

                                    Response finalResponse = response;
                                    newUser.this.runOnUiThread(new Runnable() {
                                        @Override
                                        public void run() {
                                            if(finalResponse.code()==200)
                                                profileIserted=true;
                                        } //Voir exemple du cours (diapo suivante).
                                    });

                                }
                            }).start();
                            if(profileIserted){
                                Toast t = Toast.makeText(getApplicationContext(),"user is created", Toast.LENGTH_SHORT);
                                t.show();
                                finish();
                            }else{
                                Toast t = Toast.makeText(getApplicationContext(),"erreur insertion du user: usernae already picked", Toast.LENGTH_SHORT);
                                t.show();
                            }



                        }else{
                            Toast.makeText(newUser.this, "Non permis!", Toast.LENGTH_LONG).show();
                        }
                    }
                    else{
                        Toast t = Toast.makeText(getApplicationContext(),"les mots de passes ne sont pas valides", Toast.LENGTH_SHORT);
                        t.show();
                    }
                }
            }
        });

        reset.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                username.setText("");
                password1.setText("");
                password2.setText("");
                finish();
            }
        });


    }

}
