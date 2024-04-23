package com.example.myapplication;

import static com.example.myapplication.MainActivity.API_URL;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Build;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;
import androidx.recyclerview.widget.RecyclerView;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.List;

import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class PostAdapter extends ArrayAdapter<Post> {
    private Post[] list;
    private Context context;
    private int viewRessourceId;
    private MAIN main;
    private   OkHttpClient client;
    private MediaType JSON;

    public PostAdapter(@NonNull Context context, int resource,@NonNull Post[] list, MAIN main) {
        super(context, resource);
        this.list=list;
        this.context=context;
        this.viewRessourceId=resource;
        this.main=main;
        JSON = MediaType.parse("application/json; charset=utf-8");

    }

    @Override
    public int getCount(){
        return this.list.length;
    }
    @RequiresApi(api = Build.VERSION_CODES.O)
    public View getView(int position, View convertView, ViewGroup parent){
        View view=convertView;
        if(view==null){
            LayoutInflater layoutInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            view=layoutInflater.inflate(this.viewRessourceId,parent,false);
        }
        final Post post = this.list[position];
        if(post!=null){
            final ImageView icone = view.findViewById(R.id.iconeUser);
            final TextView username = view.findViewById(R.id.usernamePost);
            final TextView time = view.findViewById(R.id.timePostp);
            final ImageView content = view.findViewById(R.id.contentpost);
            final TextView caption = view.findViewById(R.id.textView6);
            final RadioButton like = view.findViewById(R.id.like);
            final RadioGroup group = view.findViewById(R.id.radioGroup);
            final RadioButton dislike = view.findViewById(R.id.dislike);
            final Button      comments = view.findViewById(R.id.comments);
            final LinearLayout  lay = view.findViewById(R.id.laypos);

            if(post.getType().equals("annonce")){
                comments.setText("notifier vendeur");
//                like.setVisibility(View.INVISIBLE);
//                dislike.setVisibility(View.INVISIBLE);
                lay.removeView(group);
                final View memberView = main.getLayoutInflater().inflate(R.layout.prix_post_lay,null,false);
                TextView prix = (TextView) memberView.findViewById(R.id.textView3);
                prix.setText(String.valueOf(post.getPrix())+"$");
                lay.addView(memberView,0);




            }
            comments.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    if(post.getType().equals("annonce")){

                        sendMessage(post.getDescription().toString(),post.getUser_id());
                    }
                    else{
                        Toast.makeText(context,"dfghj",Toast.LENGTH_LONG ).show();
                    }
                }
            });

            username.setText(post.getUsername());
            time.setText(post.getDate_publication());
            caption.setText(post.getDescription());
            if(post.getLike()==1){
                like.setChecked(true);
            }
            else{
                dislike.setChecked(false);
            }
            //------------------------------
            like.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    if(like.isChecked()){
                       // liked(true,post.getId());

                    }
                }
            });



        }


        return view;
    }

     private void liked(boolean like, int id){

         client = new OkHttpClient();
         MediaType JSON = MediaType.parse("application/json; charset=utf-8");
         JSONObject obj = new JSONObject();

         try {
             if(like) {
                 obj.put("like", 1);
             }
             else{
                 obj.put("like", 0);
             }
         } catch (JSONException e) {
             throw new RuntimeException(e);
         }

         RequestBody corpsRequete = RequestBody.create(String.valueOf(obj), JSON);


         Request requete = new Request.Builder()
                 .url(API_URL + "/api/like/"+"/"+id)
                 .header("Authorization", "Bearer "+"token")
                 .post(corpsRequete)
                 .build();
         new Thread(new Runnable() {
             @Override
             public void run() {
                 Response response = null;
                 try {
                     response = client.newCall(requete).execute();
                 } catch (IOException e) {
                     throw new RuntimeException(e);
                 }
             }
         }).start();

     }


    private void sendMessage(String titre, int id){
        client = new OkHttpClient();
        JSONObject obj = new JSONObject();
        String s ="bonjour je suis" ;
        try{
            obj.put("user_id", id);
            obj.put("message", s);

        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        RequestBody body = RequestBody.create(String.valueOf(obj),JSON);

        Request requete = new Request.Builder()
                .url(API_URL + "/api/postMessagePrivate")
                .header("Authorization", "Bearer " + main.getToken())
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
                switch(res.code()){
                    case 200:
                        main.runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(main,String.valueOf(id),Toast.LENGTH_SHORT).show();
                            }
                        });



                        break;
                    case 500:
                        main.runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(main,"500",Toast.LENGTH_SHORT).show();
                            }
                        });
                        break;
                }
            }
        }).start();
    }



}
