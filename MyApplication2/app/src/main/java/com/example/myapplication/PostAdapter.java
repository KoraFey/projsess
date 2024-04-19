package com.example.myapplication;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Build;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.RadioButton;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;
import androidx.recyclerview.widget.RecyclerView;

import java.util.List;

public class PostAdapter extends ArrayAdapter<Post> {
    private Post[] list;
    private Context context;
    private int viewRessourceId;
    public PostAdapter(@NonNull Context context, int resource,@NonNull Post[] list) {
        super(context, resource);
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
            final TextView caption = view.findViewById(R.id.description);
            final RadioButton like = view.findViewById(R.id.like);
            final RadioButton dislike = view.findViewById(R.id.dislike);
            final Button      comments = view.findViewById(R.id.comments);
            comments.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    ///dont know what to do rn
                }
            });

            username.setText(post.getUser());
            time.setText(post.getDate_publication());
            caption.setText(post.getDescription());
            if(post.getLike()){
                like.setChecked(true);
            }
            else{
                dislike.setChecked(true);
            }
        }


        return view;
    }



}
