package com.example.myapplication;

import static com.example.myapplication.MainActivity.API_URL;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.Toast;

import com.squareup.picasso.Picasso;

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
    private ImageView test;

    private EditText username,mpd1,mpd2;

    private OkHttpClient client;

    private LinearLayout layout;

    private String id;

    private String token;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.profile);
        layout = findViewById(R.id.profile);
        submit = findViewById(R.id.toggleedit);
        cancel = findViewById(R.id.profilereturn);



        id = getIntent().getStringExtra("id");
        token = getIntent().getStringExtra("token");

        cancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

        submit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                createPopUpEdit();
            }
        });
    }


    private void createPopUpEdit(){
        LayoutInflater inflater = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
        View popUp = inflater.inflate((R.layout.profile_pop),null);
        int width = ViewGroup.LayoutParams.MATCH_PARENT;
        int height = ViewGroup.LayoutParams.WRAP_CONTENT;
        boolean focusable = true;
        PopupWindow popupWindow = new PopupWindow(popUp,width,height,focusable);

        layout.post(new Runnable() {
            @Override
            public void run() {
                popupWindow.showAtLocation(layout, Gravity.TOP,0,0);
            }
        });

        Button submit = popUp.findViewById(R.id.updateProfile);
        EditText username = popUp.findViewById(R.id.username);
        EditText mpd1 = popUp.findViewById(R.id.mdp1);
        EditText mpd2 = popUp.findViewById(R.id.mdp2);

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
                                        Toast toast = Toast.makeText(Profile.this,"updated",Toast.LENGTH_SHORT);
                                        toast.show();
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