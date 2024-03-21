package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class Login extends AppCompatActivity {
    private Button login,reset,createAccount;

    private EditText username,password;
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
                    (new Thread() {
                        @Override
                        public void run() {
                            //traitement effectué par le thread
                        }
                    }).start();
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
