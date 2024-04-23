package com.example.myapplication;

import android.content.Context;
import android.os.Build;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;


public class CommentsAdapter extends ArrayAdapter<Comments> {
    private Comments[] list;

    private Context context;

    private int ressource;

    public CommentsAdapter(@NonNull Context context, int resource,Comments[] list) {
        super(context, resource,list);
        ressource = resource;
        this.context = context;
        this.list= list;
    }

    @Override
    public int getCount() {
        return list.length;
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @NonNull
    @RequiresApi(api = Build.VERSION_CODES.O)
    public View getView(int position, View convertView, ViewGroup parent) {
        View view = convertView;
        if(view==null){
            LayoutInflater layoutInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            view=layoutInflater.inflate(this.ressource,parent,false);
        }



        final Comments comment = this.list[position];

        if(comment != null){
            TextView content = view.findViewById(R.id.message);
            TextView username = view.findViewById(R.id.sendUser);

            content.setText(comment.getCommentaire());
            username.setText(comment.getUsername());



        }
        return view;

    }








}
