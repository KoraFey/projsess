package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.inputmethod.TextAttribute;
import android.widget.TextView;

public class MAIN extends AppCompatActivity {
    private TextView title;
    private String id;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.mainlayout);
        title = findViewById(R.id.titleMain);

        id=getIntent().getStringExtra("userId");

            title.setText(id);

    }
}