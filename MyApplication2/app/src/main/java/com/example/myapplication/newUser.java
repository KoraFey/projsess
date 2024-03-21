package com.example.myapplication;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

public class newUser extends AppCompatActivity {
    private EditText username,password1,password2;
    private Button submit,reset;
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.create_login);
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
                        Toast t = Toast.makeText(getApplicationContext(),"les mots de passe sont valide", Toast.LENGTH_SHORT);
                        t.show();
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
            }
        });


    }

}
